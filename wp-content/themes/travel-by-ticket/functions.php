<?php
require_once __DIR__ . '/inc/register-elementor-widgets.php';
require_once __DIR__ . '/inc/load-assets.php';
require_once __DIR__ . '/inc/form-cities.php';
require_once __DIR__ . '/inc/form-cities-dependencies.php';

//Allow svg upload
add_filter('upload_mimes', function ($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
});

function filter_posts_by_category_in_elementor($query)
{
    $current_category = get_queried_object();
    if ($current_category) {
        $query->set('tax_query', [[
            'taxonomy' => 'category',
            'field' => 'term_id',
            'terms' => $current_category->term_id,
        ]]);
    }
}
add_action('elementor/query/posts_from_category', 'filter_posts_by_category_in_elementor');