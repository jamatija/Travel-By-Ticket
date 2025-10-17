<?php
require_once __DIR__ . '/inc/register-elementor-widgets.php';
require_once __DIR__ . '/inc/load-assets.php';
require_once __DIR__ . '/inc/form-cities.php';
require_once __DIR__ . '/inc/form-cities-dependencies.php';

//Allow svg upload
add_filter('upload_mimes', function ($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
});