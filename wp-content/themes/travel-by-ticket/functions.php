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

//Enable same base slug for posts archive and category archive
add_action('init', function () {
    $blog_page_id = (int) get_option('page_for_posts');
    if (!$blog_page_id) {
    return; 
    }

    add_rewrite_rule(
        '^blog/?$',
        'index.php?page_id=' . $blog_page_id,
        'top'
    );

    add_rewrite_rule(
        '^blog/page/([0-9]{1,})/?$',
        'index.php?page_id=' . $blog_page_id . '&paged=$matches[1]',
        'top'
    );


    add_rewrite_rule(
        '^blog/([^/]+)/([^/]+)/?$',
        'index.php?category_name=$matches[1]&name=$matches[2]',
        'top'
    );
}, 11);

add_action('after_switch_theme', function () { flush_rewrite_rules(); });
