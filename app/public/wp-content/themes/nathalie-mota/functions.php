<?php
/**
 * Nathalie Mota Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Nathalie Mota
 * @since 1.0.0
 */

/**
 * Enqueue styles and scripts
 */
function nathalie_mota_enqueue_styles_scripts() {
    // Charger le style principal du thème
    wp_enqueue_style( 'nathalie-mota-theme-css', get_stylesheet_directory_uri() . '/style.css', array(), '1.0.0', 'all' );

    // Front Page CSS
    wp_enqueue_style( 'nathalie-mota-front-page-css', get_stylesheet_directory_uri() . '/assets/css/front-page.css', array(), null );

    // Charger les polices locales
    wp_enqueue_style( 'nathalie-mota-fonts-css', get_stylesheet_directory_uri() . '/assets/css/fonts.css', array(), null );

    // Charger Lightbox CSS
    wp_enqueue_style('lightbox-css', get_stylesheet_directory_uri() . '/assets/css/lightbox.css', array(), null );

    // Charger le CSS pour le modal de Contact
    wp_enqueue_style( 'nathalie-mota-contact-css', get_stylesheet_directory_uri() . '/assets/css/contact.css', array(), null );

    // Charger le CSS pour le template single photo
    wp_enqueue_style( 'nathalie-mota-single-photo-css', get_stylesheet_directory_uri() . '/assets/css/single-photo.css', array(), null );

    // Charger les scripts JS
    wp_enqueue_script('nathalie-mota-script', get_stylesheet_directory_uri() . '/js/script.js', array('jquery'), '1.0.0', true);

    // Charger lightbox JS
    wp_enqueue_script('nathalie-mota-lightbox-script', get_stylesheet_directory_uri() . '/js/lightbox.js', array('jquery'), null, true);

    // Charger Banner JS
    wp_enqueue_script('banner', get_stylesheet_directory_uri() . '/js/banner.js', array('jquery'), null, true);

    // Ajouter les données AJAX (localize script)
    wp_localize_script('nathalie-mota-script', 'nathalieMota', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('nathalie_mota_nonce'),
    ));
}
add_action( 'wp_enqueue_scripts', 'nathalie_mota_enqueue_styles_scripts' );

/***** Register Menus *****/
function nathalie_mota_register_menus() {
    register_nav_menus(
        array(
            'menu-principal' => __('Menu Principal', 'nathalie-mota'),
            'footer' => __('Menu pied de page', 'nathalie-mota')
        )
    );
}
add_action('after_setup_theme', 'nathalie_mota_register_menus');

/***** Hook Contact *****/
function nathalie_mota_add_contact_menu_item($items, $args) {
    if ($args->theme_location == 'menu-principal') {
        $items .= '<li class="menu-item menu-item-contact"><a href="#" class="open-modal-contact">CONTACT</a></li>';
    }
    return $items;
}
add_filter('wp_nav_menu_items', 'nathalie_mota_add_contact_menu_item', 10, 2);



/***** Filtres *****/
function afficher_filtres_photos() {
    ob_start();
    get_template_part('template-parts/filtres');
    return ob_get_clean();
}

add_shortcode('filtres_photos', 'afficher_filtres_photos');
function nathalie_mota_ajax_load_photos() {
    check_ajax_referer('nathalie_mota_nonce', 'nonce');

    // Récupération et nettoyage des données des filtres
    $category_slug = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $format_slug = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $order = isset($_POST['order']) ? sanitize_text_field($_POST['order']) : 'DESC';
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;

    // Préparation de la requête WP_Query
    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $paged,
        'orderby' => 'date',
        'order' => $order,
        'tax_query' => array('relation' => 'AND'),
    );

    if ($category_slug) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => $category_slug,
        );
    }

    if ($format_slug) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format_slug,
        );
    }

    $query = new WP_Query($args);

    $photos_html = '';
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            ob_start();
            ?>
            
            <?php get_template_part('template-parts/photo_block'); ?>

            <?php
            $photos_html .= ob_get_clean();
        }
    } else {
        $photos_html = '<p>Aucune photo trouvée.</p>';
    }

    // Réinitialisation des données globales de WordPress
    wp_reset_postdata();

    // Réponse JSON
    wp_send_json_success(array(
        'html' => $photos_html,
        'max_pages' => $query->max_num_pages,
    ));
}

// Enregistrement des hooks AJAX
add_action('wp_ajax_load_photos', 'nathalie_mota_ajax_load_photos');
add_action('wp_ajax_nopriv_load_photos', 'nathalie_mota_ajax_load_photos');
