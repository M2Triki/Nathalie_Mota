<div class="photo-filters">
    <!-- Catégories -->
    <div class="filter-dropdown">
        <button class="filter-button">Catégories</button>
        <ul class="filter-options">
            <?php
            $categories = get_terms(array(
                'taxonomy' => 'categorie',
                'hide_empty' => false,
            ));
            foreach ($categories as $category) {
                echo '<li data-category="' . esc_attr($category->slug) . '">' . esc_html($category->name) . '</li>';
            }
            ?>
        </ul>
    </div>

    <!-- Formats -->
    <div class="filter-dropdown">
        <button class="filter-button">Formats</button>
        <ul class="filter-options">
            <?php
            $formats = get_terms(array(
                'taxonomy' => 'format',
                'hide_empty' => false,
            ));
            foreach ($formats as $format) {
                echo '<li data-format="' . esc_attr($format->slug) . '">' . esc_html($format->name) . '</li>';
            }
            ?>
        </ul>
    </div>

    <!-- Trier par -->
    <div class="filter-dropdown">
        <button class="filter-button">Trier par</button>
        <ul class="filter-options">
            <li data-sort="desc">Les plus récentes</li>
            <li data-sort="asc">Les plus anciennes</li>
        </ul>
    </div>
</div>