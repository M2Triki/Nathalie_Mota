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
                <div class="photo-item" data-category="<?php echo esc_attr(wp_get_post_terms(get_the_ID(), 'categorie', array('fields' => 'slugs'))[0]); ?>" data-format="<?php echo esc_attr(wp_get_post_terms(get_the_ID(), 'format', array('fields' => 'slugs'))[0]); ?>">
                    <a href="<?php the_permalink(); ?>" class="photo-link">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>" class="photo-thumbnail">
                        <?php endif; ?>
                    </a>
                    <div class="photo-hover">
                        <a href="<?php the_permalink(); ?>" class="photo-eye">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/oeil.png" alt="Voir les détails" class="icon-eye">
                        </a>
                        <div class="photo-info">
                            <span class="photo-reference"><?php echo esc_html(get_post_meta(get_the_ID(), 'reference', true)); ?></span>
                            <span class="photo-category"><?php echo esc_html(wp_get_post_terms(get_the_ID(), 'categorie', array('fields' => 'names'))[0]); ?></span>
                        </div>
                        <button class="photo-fullscreen" data-image="<?php the_post_thumbnail_url('full'); ?>">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/icon_fullscreen.png" alt="Plein écran" class="icon-fullscreen">
                        </button>
                    </div>
                </div>
            <?php endwhile;
            wp_reset_postdata();
        else : ?>
            <p>Aucune photo trouvée.</p>
        <?php endif; ?>
    </div>

</div>

<div class="lightbox hidden" id="lightbox">
    <button class="lightbox__close" aria-label="Fermer">✖</button>
    <div class="lightbox__content">
        <img src="" alt="Photo en plein écran" class="lightbox__image">
    </div>
</div>

</div>

<?php get_footer(); ?>