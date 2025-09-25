<?php
require_once __DIR__ . '/inc/register-elementor-widgets.php';
require_once __DIR__ . '/inc/load-assets.php';

add_filter('upload_mimes', function ($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
});

