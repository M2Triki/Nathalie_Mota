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
            <a href="<?php echo home_url(); ?>">
                <?php 
                if ( has_custom_logo() ) {
                    the_custom_logo(); 
                } else {
                    echo '<h1>' . get_bloginfo( 'name' ) . '</h1>'; 
                }
                ?>
            </a>
        </div>
        
        <div class="menu-toggle">
            <span></span>
            <span></span>
            <span></span>
        </div>
        
        <nav class="menu">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'menu-principal',
                'container' => false,
                'menu_class' => 'menu-principal', 
            ));
            ?>
        </nav>
    </header>

    <?php get_template_part('template-parts/contact-modal'); ?>