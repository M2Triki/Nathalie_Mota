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

	wp_enqueue_style( 'nathalie-mota-theme-css', get_stylesheet_directory_uri() . '/style.css', array('astra-theme-css'), CHILD_THEME_NATHALIE_MOTA_VERSION, 'all' );
	wp_enqueue_script('script', get_template_directory_uri() . '/js/script.js', array(), '1.0', true);
	wp_enqueue_style( 'space-mono-google-font', 'https://fonts.googleapis.com/css2?family=Space+Mono:ital,wght@0,400;0,700;1,400;1,700&display=swap', false );

}

add_action( 'wp_enqueue_script', 'child_enqueue_styles', 15 );


function register_my_menus() {
    register_nav_menus(array(
        'menu-principal' => __('Menu Principal'),
    ));
}
add_action('init', 'register_my_menus');
