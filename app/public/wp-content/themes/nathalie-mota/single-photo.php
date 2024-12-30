<?php get_header(); ?>
<div class="photo-template-container">
    <div class="photo-content-container">
        <div class="photo-info-left">
            <h2><?php the_title(); ?></h2>
            <p><strong>Référence :</strong> <?php echo get_post_meta(get_the_ID(), 'reference', true); ?></p>
            <p><strong>Catégorie :</strong> <?php the_terms(get_the_ID(), 'categorie'); ?></p>
            <p><strong>Format :</strong> <?php the_terms(get_the_ID(), 'format'); ?></p>
            <p><strong>Type :</strong> <?php echo get_post_meta(get_the_ID(), 'type', true); ?></p>
            <p><strong>Année :</strong> <?php echo get_post_meta(get_the_ID(), 'annee', true); ?></p>
        </div>

        <div class="photo-info-right">
            <?php if (has_post_thumbnail()) : ?>
                <img id="main-photo" src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php the_title(); ?>">
            <?php endif; ?>
        </div>

        <div class="photo-interaction-bar">
            <div class="contact-link">
                <p>Cette photo vous intéresse ?</p>
                <a href="#" class="contact-modal-trigger" data-photo-id="<?php echo get_post_meta(get_the_ID(), 'reference', true); ?>">Contact</a>
            </div>
            <div class="photo-navigation">
                <?php
                $prev_post = get_previous_post();
                $next_post = get_next_post();
    
                echo '<div class="thumbnail-container">';
                if ($prev_post) :
                    echo '<img class="thumbnail prev-thumbnail" src="' . get_the_post_thumbnail_url($prev_post->ID, 'thumbnail') . '" alt="Précedent">';
                endif;
                echo '<img class="thumbnail current-thumbnail" src="' . get_the_post_thumbnail_url(get_the_ID(), 'thumbnail') . '" alt="Actuelle">';
                if ($next_post) :
                    echo '<img class="thumbnail next-thumbnail" src="' . get_the_post_thumbnail_url($next_post->ID, 'thumbnail') . '" alt="Suivant">';
                endif;
                echo '</div>';
    
                if ($prev_post) :
                    echo '<a href="' . get_permalink($prev_post->ID) . '" class="photo-nav-link prev-link">';
                    echo '<img src="' . get_stylesheet_directory_uri() . '/assets/img/precedent.png" alt="Précedent" class="nav-arrow">';
                    echo '</a>';
                endif;
    
                if ($next_post) :
                    echo '<a href="' . get_permalink($next_post->ID) . '" class="photo-nav-link next-link">';
                    echo '<img src="' . get_stylesheet_directory_uri() . '/assets/img/suivant.png" alt="Suivant" class="nav-arrow">';
                    echo '</a>';
                endif;
                ?>
            </div>
        </div>
    </div>

    <div class="related-photos">
        <h3>Vous aimerez aussi</h3>
        <div class="related-photos-grid">
            <?php
            $related_photos = new WP_Query(array(
                'post_type' => 'photo',
                'posts_per_page' => 2,
                'post__not_in' => array(get_the_ID()),
                'tax_query' => array(
                    array(
                        'taxonomy' => 'categorie',
                        'field' => 'term_id',
                        'terms' => wp_get_post_terms(get_the_ID(), 'categorie', array('fields' => 'ids')),
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
</div>

<?php get_footer(); ?>