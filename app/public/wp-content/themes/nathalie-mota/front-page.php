<?php get_header(); ?>

<div class="hero-banner" style="background-image: url('<?php echo get_stylesheet_directory_uri(); ?>/assets/img/banner.jpg');">
    <h1>PHOTOGRAPHE EVENT</h1>
</div>


<div class="container">
    <!-- Filtres -->
    <!-- Filtres -->
<div class="photo-filters">
    <!-- Dropdown pour Catégories -->
    <select id="categorie" name="categorie">
        <option value="">Toutes les catégories</option>
        <?php
        $categories = get_terms(array(
            'taxonomy' => 'categorie',
            'hide_empty' => false,
        ));
        foreach ($categories as $category) {
            echo '<option value="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</option>';
        }
        ?>
    </select>

    <!-- Dropdown pour Formats -->
    <select id="format" name="format">
        <option value="">Tous les formats</option>
        <?php
        $formats = get_terms(array(
            'taxonomy' => 'format',
            'hide_empty' => false,
        ));
        foreach ($formats as $format) {
            echo '<option value="' . esc_attr($format->slug) . '">' . esc_html($format->name) . '</option>';
        }
        ?>
    </select>

    <!-- Dropdown pour Trier par -->
    <select id="order" name="order">
        <option value="desc">Les plus récentes</option>
        <option value="asc">Les plus anciennes</option>
    </select>
</div>

<!-- Grille de photos -->
<div class="photo-gallery">
    <div class="photo-grid" id="photo-grid">
        <?php
        $photos = new WP_Query(array(
            'post_type' => 'photo',
            'posts_per_page' => 8,
        ));

        if ($photos->have_posts()) :
            while ($photos->have_posts()) : $photos->the_post(); ?>
                <div class="photo-item">
                    <a href="<?php the_permalink(); ?>">
                        <?php if (has_post_thumbnail()) : ?>
                            <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>">
                        <?php endif; ?>
                    </a>
                </div>
            <?php endwhile;
            wp_reset_postdata();
        else : ?>
            <p>Aucune photo trouvée.</p>
        <?php endif; ?>
    </div>
</div>
</div>

<?php get_footer(); ?>