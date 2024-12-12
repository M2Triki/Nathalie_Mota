<footer>
    <?php if ( has_nav_menu( 'footer' ) ) : ?>
        <nav class="footer-nav">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'footer',
                'container'      => false,
                'menu_class'     => 'footer-menu',
            ) );
            ?>
        </nav>
    <?php endif; ?>
</footer>

<?php get_template_part('template-parts/lightbox'); ?>

<?php wp_footer(); ?>