<?php get_header(); ?>

<div class="hero-banner" style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/img/banner.jpg');">
    <h1>PHOTOGRAPHE EVENT</h1>
</div>


<div class="container">

<?php get_template_part('template-parts/filtres'); ?>

<div class="photo-gallery">
    <div class="photo-grid" id="photo-grid">
        <?php
        $photos = new WP_Query(array(
            'post_type' => 'photo',
            'posts_per_page' => 8,
            'order' => 'DESC',
        ));

        if ($photos->have_posts()) :
            while ($photos->have_posts()) : $photos->the_post(); ?>
                
            <?php get_template_part('template-parts/photo_block'); ?>

            <?php endwhile;
            wp_reset_postdata();
        else : ?>
            <p>Aucune photo trouvée.</p>
        <?php endif; ?>
    </div>

</div>


</div>

<?php get_footer(); ?>