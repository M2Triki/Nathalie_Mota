<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title(); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <header>
        <div class="logo">
        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/logo_nathalie_mota.png" 
        alt="Logo <?php echo bloginfo('name'); ?>">
        </div>
        <nav>
            <?php wp_nav_menu(array('theme_location' => 'menu-principal')); ?>
        </nav>
    </header>
