<?php
function travel_tickets_widget_scripts()
{
    wp_register_script('testimonial-widget', get_stylesheet_directory_uri() . '/resources/js/hero.js', ['swiper'], false, true);
    
}
add_action('wp_enqueue_scripts', 'travel_tickets_widget_scripts');

function travel_tickets_widget_styles()
{
    wp_register_style('testimonial-widget', get_stylesheet_directory_uri() . '/resources/css/hero.css');
    wp_register_style('popular-widget', get_stylesheet_directory_uri() . '/resources/css/hero.css');

}
add_action('wp_enqueue_scripts', 'travel_tickets_widget_styles');


function register_widgets($widgets_manager)
{
    require_once(__DIR__ . '/../widgets/LinkWidget.php');

    $widgets_manager->register(new \LinkWidget());
}
add_action('elementor/widgets/register', 'register_widgets');

