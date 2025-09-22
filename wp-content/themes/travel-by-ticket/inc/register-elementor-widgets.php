<?php
function travel_tickets_widget_styles()
{
    wp_register_style('link-widget', get_stylesheet_directory_uri() . '/assets/css/link-widget.css');

}
add_action('wp_enqueue_scripts', 'travel_tickets_widget_styles');


function register_widgets($widgets_manager)
{
    require_once(__DIR__ . '/../widgets/LinkWidget.php');

    $widgets_manager->register(new \LinkWidget());
}
add_action('elementor/widgets/register', 'register_widgets');

