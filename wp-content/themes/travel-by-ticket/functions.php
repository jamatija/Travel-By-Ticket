<?php
function travel_by_ticket_enqueue_styles() {
    wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
add_action( 'wp_enqueue_scripts', 'travel_by_ticket_enqueue_styles' );

add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style(
        'child-style',
        get_stylesheet_uri(),
        ['hello-elementor-theme-style'], 
        wp_get_theme()->get('Version')
    );
}, 20);


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

// Register newsletter form styles
add_action( 'wp_enqueue_scripts', function() {
    wp_register_style(
        'newsletter-css',
        get_stylesheet_directory_uri() . '/assets/css/newsletter.css',
        [],
        '1.0'
    );
}, 5 );
//Load styles when newsletter form is on page
add_filter( 'wpcf7_form_elements', function ( $html ) {
    if ( strpos( $html, 'newsletter-form' ) !== false ) {
        wp_enqueue_style( 'newsletter-css' );
    }
    return $html;
});