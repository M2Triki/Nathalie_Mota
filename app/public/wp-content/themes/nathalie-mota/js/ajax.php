<?php

if (!defined('ABSPATH')) {
    exit; // Empêche l'accès direct au fichier
}

function nathalie_mota_ajax_load_photos() {
    check_ajax_referer('nathalie_mota_nonce', 'nonce');

    $category_slug = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';
    $format_slug = isset($_POST['format']) ? sanitize_text_field($_POST['format']) : '';
    $order = isset($_POST['order']) ? sanitize_text_field($_POST['order']) : 'DESC';
    $paged = isset($_POST['paged']) ? intval($_POST['paged']) : 1;

    $args = array(
        'post_type' => 'photo',
        'posts_per_page' => 8,
        'paged' => $paged,
        'orderby' => 'date',
        'order' => $order,
        'tax_query' => array('relation' => 'AND'),
    );

    if ($category_slug) {
        $args['tax_query'][] = array(
            'taxonomy' => 'categorie',
            'field' => 'slug',
            'terms' => $category_slug,
        );
    }

    if ($format_slug) {
        $args['tax_query'][] = array(
            'taxonomy' => 'format',
            'field' => 'slug',
            'terms' => $format_slug,
        );
    }

    $query = new WP_Query($args);
    $photos_html = '';

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            ob_start();
            ?>
            <div class="photo-item">
                <a href="<?php the_permalink(); ?>">
                    <img src="<?php the_post_thumbnail_url('medium'); ?>" alt="<?php the_title(); ?>">
                </a>
            </div>
            <?php
            $photos_html .= ob_get_clean();
        }
    } else {
        $photos_html = '<p>Aucune photo trouvée.</p>';
    }

    wp_reset_postdata();

    wp_send_json_success(array(
        'html' => $photos_html,
        'max_pages' => $query->max_num_pages,
    ));
}
add_action('wp_ajax_load_photos', 'nathalie_mota_ajax_load_photos');
add_action('wp_ajax_nopriv_load_photos', 'nathalie_mota_ajax_load_photos');