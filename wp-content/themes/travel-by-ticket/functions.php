<?php
function enqueue_bus_search_scripts2() {
    if (is_page() || is_single()) {
        global $post;
        if (has_shortcode($post->post_content, 'bus_search_form')) {
            // Select2 CSS
            wp_enqueue_style(
                'select2',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
                array(),
                '4.1.0'
            );
            
            // Select2 JS
            wp_enqueue_script(
                'select2',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                array('jquery'),
                '4.1.0',
                true
            );
            
            // Tvoj custom JS
            wp_enqueue_script(
                'bus-search-form', 
                get_stylesheet_directory_uri() . '/assets/js/bus-search.js', 
                array('jquery', 'select2'), // Zavisi od Select2
                '1.0.1', 
                true
            );
            
            wp_enqueue_style(
                'bus-search-form', 
                get_stylesheet_directory_uri() . '/assets/css/bus-search.css'
            );
            
            wp_localize_script('bus-search-form', 'busSearchConfig', array(
                'apiUrl' => rest_url('busticket/v1/cities/'),
                'nonce' => wp_create_nonce('wp_rest'),
                'lang' => 'MNE'
            ));

               // Flatpickr JS
            wp_enqueue_script(
                'flatpickr',
                'https://cdn.jsdelivr.net/npm/flatpickr',
                array(),
                '4.6.13',
                true
            );


            // Flatpickr CSS
            wp_enqueue_style(
                'flatpickr',
                'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css',
                array(),
                '4.6.13'
            );
        }
    }
}
add_action('wp_enqueue_scripts', 'enqueue_bus_search_scripts2');

require_once __DIR__ . '/inc/register-elementor-widgets.php';
require_once __DIR__ . '/inc/load-assets.php';
require_once __DIR__ . '/inc/form-cities.php';

add_filter('upload_mimes', function ($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
});