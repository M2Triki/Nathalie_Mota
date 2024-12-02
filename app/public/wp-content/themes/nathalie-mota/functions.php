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

    // Charger le CSS pour le modal de Contact
    wp_enqueue_style( 'nathalie-mota-contact-css', get_stylesheet_directory_uri() . '/assets/css/contact.css', array(), null );

    // Charger le CSS pour le template single photo
    wp_enqueue_style( 'nathalie-mota-single-photo-css', get_stylesheet_directory_uri() . '/assets/css/single-photo.css', array(), null );

    // Charger les scripts JS
    wp_enqueue_script('nathalie-mota-script', get_stylesheet_directory_uri() . '/js/script.js', array('jquery'), '1.0.0', true);
}
add_action( 'wp_enqueue_scripts', 'nathalie_mota_enqueue_styles_scripts' );

/**
 * Register Menus
 */
function nathalie_mota_register_menus() {
    register_nav_menus(
        array(
            'menu-principal' => __('Menu Principal', 'nathalie-mota'),
            'footer' => __('Menu pied de page', 'nathalie-mota')
        )
    );
}
add_action('after_setup_theme', 'nathalie_mota_register_menus');

/* Function hook Contact */
function nathalie_mota_add_contact_menu_item($items, $args) {
    // Vérifie que nous ajoutons l'élément uniquement au menu principal
    if ($args->theme_location == 'menu-principal') {
        // Ajoute l'élément "Contact" avec une classe personnalisée
        $items .= '<li class="menu-item menu-item-contact"><a href="#" class="open-modal-contact">CONTACT</a></li>';
    }
    return $items;
}
add_filter('wp_nav_menu_items', 'nathalie_mota_add_contact_menu_item', 10, 2);

/* Fonction pour afficher les filtres dans la page d'accueil */
function afficher_filtres_photos() {
    ob_start();
    get_template_part('template-parts/filtres');
    return ob_get_clean();
}
add_shortcode('filtres_photos', 'afficher_filtres_photos');

/* Pour que les filtres functionnent avec AJAX */
function fetch_filtered_photos() {
    $args = array(
        'post_type' => 'photo', // Assurez-vous que le CPT est bien nommé "photo"
        'posts_per_page' => 8,
        'orderby' => 'date',
        'order' => isset($_GET['order']) ? sanitize_text_field($_GET['order']) : 'desc',
    );

    // Ajouter un filtre pour les catégories
    if (!empty($_GET['categorie'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => sanitize_text_field($_GET['categorie']),
        );
    }

    // Ajouter un filtre pour les formats
    if (!empty($_GET['format'])) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => sanitize_text_field($_GET['format']),
        );
    }

    $query = new WP_Query($args);
    $photos = array();

    if ($query->have_posts()) :
        while ($query->have_posts()) : $query->the_post();
            $photos[] = array(
                'id' => get_the_ID(),
                'title' => get_the_title(),
                'link' => get_permalink(),
                'featured_media_src_url' => get_the_post_thumbnail_url(get_the_ID(), 'medium'),
            );
        endwhile;
    endif;

    wp_reset_postdata();
    wp_send_json($photos);
}

// Ajouter le endpoint REST API
add_action('rest_api_init', function () {
    register_rest_route('wp/v2', '/photo_custom_endpoint', array(
        'methods' => 'GET',
        'callback' => 'fetch_filtered_photos',
    ));
});
