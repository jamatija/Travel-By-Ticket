<?php
// Omogući paginaciju na Pages
// function enable_page_pagination() {
//     global $wp_rewrite;
//     $wp_rewrite->use_verbose_page_rules = true;
// }
// add_action('init', 'enable_page_pagination');

// // Dodaj page var u query vars
// function add_page_query_var($vars) {
//     $vars[] = 'page';
//     return $vars;
// }
// add_filter('query_vars', 'add_page_query_var');

// // Flush rewrite rules (samo jednom)
// function flush_rewrite_on_activation() {
//     enable_page_pagination();
//     flush_rewrite_rules();
// }
// register_activation_hook(__FILE__, 'flush_rewrite_on_activation');

add_action('pre_get_posts', function( WP_Query $q ){
    if ( is_admin() || ! $q->is_main_query() ) return;

    // "Posts page" (home) kada je postavljena u Settings > Reading 
    if ( $q->is_home() ) {
        $ppp = 7;


        if ( $ppp > 0 ) {
            $q->set('posts_per_page', $ppp);
            $q->set('ignore_sticky_posts', true);
        }
    }
});


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