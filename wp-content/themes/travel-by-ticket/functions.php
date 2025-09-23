<?php
function travel_by_ticket_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'travel_by_ticket_enqueue_styles' );


function travel_enqueue_slider_assets() {
    wp_enqueue_style(
        'swiper-css',
        'https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css',
        [],
        '12.0.2',
    );

    wp_register_script(
        'swiper',
        'https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.js',
        [],
        '12.0.2',
        true
    );
}
add_action('wp_enqueue_scripts', 'travel_enqueue_slider_assets');



require_once __DIR__ . '/inc/register-elementor-widgets.php';

add_filter('upload_mimes', function ($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
});

