<div class="photo-filters">
    <select id="filter-category">
        <option value="">Catégories</option>
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

    <select id="filter-format">
        <option value="">Formats</option>
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

    <select id="filter-date">
        <option value="">Trier par</option>
        <option value="desc">Les plus récentes</option>
        <option value="asc">Les plus anciennes</option>
    </select>
</div>