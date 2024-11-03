<?php get_header(); ?>

<div class="photo-content-container">
    <div class="photo-info-left" style="width: 50%;">
        <h2><?php the_title(); ?></h2>
        <p><strong>Référence :</strong> <?php echo get_post_meta(get_the_ID(), 'reference', true); ?></p>
        <p><strong>Catégorie :</strong> <?php the_terms(get_the_ID(), 'categorie'); ?></p>
        <p><strong>Format :</strong> <?php the_terms(get_the_ID(), 'format'); ?></p>
        <p><strong>Date de prise de vue :</strong> <?php echo get_the_date(); ?></p>
    </div>

    <div class="photo-info-right" style="width: 50%;">
        <?php if (has_post_thumbnail()) : ?>
            <img src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php the_title(); ?>" style="width: 100%; height: auto; object-fit: contain;">
        <?php endif; ?>
    </div>
</div>

<div class="photo-interaction-bar" style="height: 118px; display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
    <div class="contact-link">
        <a href="#" class="contact-modal-trigger" data-photo-id="<?php echo get_post_meta(get_the_ID(), 'reference', true); ?>">Contactez-moi pour l'achat</a>
    </div>
    <div class="photo-navigation">
        <?php
        $prev_post = get_previous_post();
        $next_post = get_next_post();

        if ($prev_post) :
            echo '<a href="' . get_permalink($prev_post->ID) . '" class="photo-nav-link prev-link">Précédent</a>';
        endif;

        if ($next_post) :
            echo '<a href="' . get_permalink($next_post->ID) . '" class="photo-nav-link next-link">Suivant</a>';
        endif;
        ?>
    </div>
</div>

<div class="related-photos">
    <h2>Photos apparentées</h2>
    <div class="related-photos-grid">
        <?php
        $related_photos = new WP_Query(array(
            'post_type' => 'photo',
            'posts_per_page' => 4,
            'post__not_in' => array(get_the_ID()),
            'tax_query' => array(
                array(
                    'taxonomy' => 'categorie',
                    'field' => 'slug',
                    'terms' => wp_get_post_terms(get_the_ID(), 'categorie', array('fields' => 'slugs')),
                ),
            ),
        ));

        if ($related_photos->have_posts()) :
            while ($related_photos->have_posts()) : $related_photos->the_post();
                get_template_part('template-parts/photo_block');
            endwhile;
            wp_reset_postdata();
        else :
            echo '<p>Aucune photo apparentée trouvée.</p>';
        endif;
        ?>
    </div>
</div>


<?php get_footer(); ?>