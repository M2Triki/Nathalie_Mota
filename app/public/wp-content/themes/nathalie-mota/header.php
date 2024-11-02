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
        <!-- Affichage du logo modifiable via le Customizer -->
        <div class="logo">
            <a href="<?php echo home_url(); ?>">
                <?php 
                if ( has_custom_logo() ) {
                    the_custom_logo(); // Affiche le logo personnalisé défini dans le Customizer
                } else {
                    echo '<h1>' . get_bloginfo( 'name' ) . '</h1>'; // Affiche le titre du site si aucun logo n'est défini
                }
                ?>
            </a>
        </div>
        
        <!-- Affichage du menu principal modifiable via le back-office -->
        <nav>
            <?php
            wp_nav_menu(array(
                'theme_location' => 'menu-principal', // L'emplacement du menu que tu as défini dans functions.php
                'container' => false,                // Pas de conteneur supplémentaire
                'menu_class' => 'menu-principal',    // Classe CSS pour styliser le menu si nécessaire
            ));
            ?>
        </nav>
    </header>
        <!-- Ajout contact modal -->
        <?php get_template_part('template-parts/contact-modal'); ?>
    <?php wp_footer(); ?>
</body>
</html>