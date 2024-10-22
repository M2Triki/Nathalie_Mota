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
 * Enqueue styles
 */
function child_enqueue_styles() {

    wp_enqueue_style( 'astra-theme-css', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'nathalie-mota-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_NATHALIE_MOTA_VERSION, 'all' );
    wp_enqueue_style( 'nathalie-mota-fonts-css', get_stylesheet_directory_uri() . '/assets/css/fonts.css', array(), null );
    wp_enqueue_script('script', get_stylesheet_directory_uri() . '/js/script.js', array(), '1.0', true);
}
add_action( 'wp_enqueue_scripts', 'child_enqueue_styles' );

add_action( 'wp_enqueue_script', 'child_enqueue_styles', 15 );


// Enregistrer le menu principal pour le thème Nathalie Mota
function nathalie_mota_register_menus() {
    register_nav_menus(
        array(
            'menu-principal' => __('Menu Principal', 'nathalie-mota')
        )
    );
}
add_action('after_setup_theme', 'nathalie_mota_register_menus');

add_action( 'wp_enqueue_scripts', 'nathalie_mota_dequeue_google_fonts', 20 );
function nathalie_mota_dequeue_google_fonts() {
    wp_dequeue_style( 'astra-google-fonts' );
}
