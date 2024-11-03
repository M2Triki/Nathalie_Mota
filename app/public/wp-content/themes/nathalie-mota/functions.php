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
 * Define Constants
 */
define( 'CHILD_THEME_NATHALIE_MOTA_VERSION', '1.0.0' );

/**
 * Enqueue styles and scripts
 */
function nathalie_mota_enqueue_styles_scripts() {
    // Charger le style du thème parent (Astra)
    wp_enqueue_style( 'astra-theme-css', get_template_directory_uri() . '/style.css' );
    
    // Charger le style du thème enfant
    wp_enqueue_style( 'nathalie-mota-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_NATHALIE_MOTA_VERSION, 'all' );
    
    // Charger les polices locales (fonts.css)
    wp_enqueue_style( 'nathalie-mota-fonts-css', get_stylesheet_directory_uri() . '/assets/css/fonts.css', array(), null );

    // Charger le CSS pour le modal de Contact
    wp_enqueue_style( 'nathalie-mota-contact-css', get_stylesheet_directory_uri() . '/assets/css/contact.css', array(), null );

    // Charger le CSS pour le template single photo
    wp_enqueue_style( 'nathalie-mota-single-photo-css', get_stylesheet_directory_uri() . '/assets/css/single-photo.css', array(), null );
    
    // Charger les scripts du thème enfant
    wp_enqueue_script('nathalie-mota-script', get_stylesheet_directory_uri() . '/js/script.js', array(), '1.0', true);
}
add_action( 'wp_enqueue_scripts', 'nathalie_mota_enqueue_styles_scripts' );

/**
 * Deregister Google Fonts from Astra
 */
function nathalie_mota_dequeue_google_fonts() {
    wp_dequeue_style( 'astra-google-fonts' );
}
add_action( 'wp_enqueue_scripts', 'nathalie_mota_dequeue_google_fonts', 20 );

/**
 * Register Menus
 */
function nathalie_mota_register_menus() {
    register_nav_menus(
        array(
            'menu-principal' => __('Menu Principal', 'nathalie-mota'),
            'footer' => __( 'Menu pied de page', 'nathalie-mota' )
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


// Fonction pour afficher les filtres dans la page d'accueil.
function afficher_filtres_photos() {
    ob_start();
    get_template_part('template-parts/filtres');
    return ob_get_clean();
}
add_shortcode('filtres_photos', 'afficher_filtres_photos');

