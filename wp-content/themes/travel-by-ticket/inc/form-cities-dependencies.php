<?php
function page_has_shortcode_anywhere( $shortcode ) {
    if ( !is_singular() ) return false;
    $post = get_post();
    if ( !$post ) return false;

    if ( has_shortcode( $post->post_content, $shortcode ) ) return true;

    // Elementor
    $el = get_post_meta( $post->ID, '_elementor_data', true );
    if ( is_string($el) && strpos( $el, '['.$shortcode ) !== false ) return true;
    
    return false;
}
function enqueue_bus_search_scripts2() {
    if ( is_singular() && page_has_shortcode_anywhere('bus_search_form') ) {
        // Select2 CSS
        wp_enqueue_style(
            'select2',
            'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css',
            array(),
            '4.1.0'
        );

        // Flatpickr CSS
        wp_enqueue_style(
            'flatpickr',
            'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css',
            array(),
            '4.6.13'
        );

        wp_enqueue_style(
            'bus-search-form', 
            get_stylesheet_directory_uri() . '/assets/css/bus-search.css', ['select2','flatpickr'], null
        );
        
        // Select2 JS
        wp_enqueue_script(
            'select2',
            'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
            array('jquery'),
            '4.1.0',
            true
        );

        // Flatpickr JS
        wp_enqueue_script(
            'flatpickr',
            'https://cdn.jsdelivr.net/npm/flatpickr',
            array(),
            '4.6.13',
            true
        );

        wp_enqueue_script(
            'bus-search-form', 
            get_stylesheet_directory_uri() . '/assets/js/bus-search.js', 
            array('jquery', 'select2'), 
            '1.0.1', 
            true
        );
        
        wp_localize_script('bus-search-form', 'busSearchConfig', array(
            'apiUrl' => rest_url('busticket/v1/cities/'),
            'nonce' => wp_create_nonce('wp_rest'),
            'lang' => 'MNE'
        ));

    }
}
add_action('wp_enqueue_scripts', 'enqueue_bus_search_scripts2');