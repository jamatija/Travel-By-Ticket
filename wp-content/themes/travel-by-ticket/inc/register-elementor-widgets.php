<?php
function travel_tickets_widget_styles()
{
    wp_register_style('link-widget', get_stylesheet_directory_uri() . '/assets/css/link-widget.css');
    wp_register_style('carousel-widget', get_stylesheet_directory_uri() . '/assets/css/carousel-widget.css');
    wp_register_style('image-carousel-widget', get_stylesheet_directory_uri() . '/assets/css/image-carousel-widget.css');
    wp_register_style('testimonial-widget', get_stylesheet_directory_uri() . '/assets/css/testimonial-widget.css');
    wp_register_style('grid-with-author', get_stylesheet_directory_uri() . '/assets/css/grid-with-author.css');
    wp_register_style('tab-widget', get_stylesheet_directory_uri() . '/assets/css/tab-widget.css');
    wp_register_style('language-switcher-widget', get_stylesheet_directory_uri() . '/assets/css/language-switcher-widget.css');
    wp_register_style('logo-hover-widget', get_stylesheet_directory_uri() . '/assets/css/logo-widget.css');
    wp_register_style('category-widget', get_stylesheet_directory_uri() . '/assets/css/category-widget.css');
    wp_register_style('posts-loop-widget', get_stylesheet_directory_uri() . '/assets/css/posts-loop-widget.css', array('grid-with-author'));
    wp_register_style('shaped-image-widget', get_stylesheet_directory_uri() . '/assets/css/shaped-image-widget.css');
}
add_action('wp_enqueue_scripts', 'travel_tickets_widget_styles');



function travel_tickets_pulse_register_widget_scripts()
{
    wp_register_script('carousel-widget', get_stylesheet_directory_uri() . '/assets/js/carousel.js', ['swiper'], false, true);
    wp_register_script('image-carousel-widget', get_stylesheet_directory_uri() . '/assets/js/image-carousel.js', ['swiper'], false, true);
    wp_register_script('testimonial-widget', get_stylesheet_directory_uri() . '/assets/js/testimonial-carousel.js', ['swiper'], false, true);
    wp_register_script('tab-widget', get_stylesheet_directory_uri() . '/assets/js/tab-widget.js', ['swiper'],false, true);
    wp_register_script('language-switcher-widget', get_stylesheet_directory_uri() . '/assets/js/language-switcher-widget.js', [],false, true);
    wp_register_script('category-widget', get_stylesheet_directory_uri() . '/assets/js/category.js', [],false, true);
}
add_action('wp_enqueue_scripts', 'travel_tickets_pulse_register_widget_scripts');



function register_widgets($widgets_manager)
{
    require_once(__DIR__ . '/../widgets/LinkWidget.php');
    require_once(__DIR__ . '/../widgets/CarouselWidget.php');
    require_once(__DIR__ . '/../widgets/HeadingWidget.php');
    require_once(__DIR__ . '/../widgets/ImageCarouselWidget.php');
    require_once(__DIR__ . '/../widgets/TestimonialWidget.php');
    require_once(__DIR__ . '/../widgets/GridWithAuthorWidget.php');
    require_once(__DIR__ . '/../widgets/TabWidget.php');
    require_once(__DIR__ . '/../widgets/LanguageSwitcherWidget.php');
    require_once(__DIR__ . '/../widgets/LogoWidget.php');
    require_once(__DIR__ . '/../widgets/CategoryWidget.php');
    require_once(__DIR__ . '/../widgets/PostsLoopWidget.php');
    require_once(__DIR__ . '/../widgets/ShapedImageWidget.php');
    
    $widgets_manager->register(new \LinkWidget());
    $widgets_manager->register(new \CarouselWidget());
    $widgets_manager->register(new \HeadingWidget());
    $widgets_manager->register(new \ImageCarouselWidget());
    $widgets_manager->register(new \TestimonialWidget());
    $widgets_manager->register(new \GridWithAuthorWidget());
    $widgets_manager->register(new \TabWidget());
    $widgets_manager->register(new \LanguageSwitcherWidget());
    $widgets_manager->register(new \LogoWidget());
    $widgets_manager->register(new \CategoryWidget());
    $widgets_manager->register(new \PostsLoopWidget());
    $widgets_manager->register(new \ShapedImageWidget());
}
add_action('elementor/widgets/register', 'register_widgets');

