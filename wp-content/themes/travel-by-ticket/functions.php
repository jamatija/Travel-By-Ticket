<?php
function travel_by_ticket_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'travel_by_ticket_enqueue_styles' );

require_once __DIR__ . '/inc/register-elementor-widgets.php';

add_filter('upload_mimes', function ($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
});