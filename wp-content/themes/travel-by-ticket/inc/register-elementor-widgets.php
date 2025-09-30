<?php
function travel_tickets_widget_styles()
{
    wp_register_style('link-widget', get_stylesheet_directory_uri() . '/assets/css/link-widget.css');
    wp_register_style('carousel-widget', get_stylesheet_directory_uri() . '/assets/css/carousel-widget.css');
    wp_register_style('image-carousel-widget', get_stylesheet_directory_uri() . '/assets/css/image-carousel-widget.css');
    wp_register_style('testimonial-widget', get_stylesheet_directory_uri() . '/assets/css/testimonial-widget.css');
}
add_action('wp_enqueue_scripts', 'travel_tickets_widget_styles');



function travel_tickets_pulse_register_widget_scripts()
{
    wp_register_script('carousel-widget', get_stylesheet_directory_uri() . '/assets/js/carousel.js', ['swiper'], false, true);
    wp_register_script('image-carousel-widget', get_stylesheet_directory_uri() . '/assets/js/image-carousel.js', ['swiper'], false, true);
    wp_register_script('testimonial-widget', get_stylesheet_directory_uri() . '/assets/js/testimonial-carousel.js', ['swiper'], false, true);
}
add_action('wp_enqueue_scripts', 'travel_tickets_pulse_register_widget_scripts');



function register_widgets($widgets_manager)
{
    require_once(__DIR__ . '/../widgets/LinkWidget.php');
    require_once(__DIR__ . '/../widgets/CarouselWidget.php');
    require_once(__DIR__ . '/../widgets/HeadingWidget.php');
    require_once(__DIR__ . '/../widgets/ImageCarouselWidget.php');
    require_once(__DIR__ . '/../widgets/TestimonialWidget.php');
    
    $widgets_manager->register(new \LinkWidget());
    $widgets_manager->register(new \CarouselWidget());
    $widgets_manager->register(new \HeadingWidget());
    $widgets_manager->register(new \ImageCarouselWidget());
    $widgets_manager->register(new \TestimonialWidget());
}
add_action('elementor/widgets/register', 'register_widgets');

