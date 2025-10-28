<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class CategoryWidget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'categories_widget';
    }

    public function get_style_depends()
    {
        return ['category-widget'];
    }

    public function get_script_depends()
    {
        return ['category-widget'];
    }

    public function get_title()
    {
        return __('Post Categories', 'eks');
    }

    public function get_icon()
    {
        return 'eicon-post-list';
    }

    public function get_categories()
    {
        return ['Eks'];
    }

    protected function render()
    {
        $categories = get_categories();
        
        if (empty($categories)) {
            echo '<p>' . __('No categories found.', 'eks') . '</p>';
            return;
        }

        $current_category_id = get_queried_object_id();
        $is_blog_page = is_home() && !is_category();
        $default_classes = 'filter';

        echo '<div class="custom-categories-widget">';

        // Desktop version - all links in one scrollable line
        echo '<div class="scroll-container">';

        // "All" link
        $all_class = $is_blog_page ? $default_classes . ' current-category' : $default_classes;
        echo sprintf(
            '<a href="%s" class="%s">%s</a>',
            esc_url(get_permalink(get_option('page_for_posts'))),
            esc_attr($all_class),
            __('All', 'eks')
        );

        // Category links
        foreach ($categories as $category) {
            if ($category->slug === 'uncategorized') {
                continue;
            }

            $is_current = $category->term_id == $current_category_id;
            $class = $is_current ? $default_classes . ' current-category' : $default_classes;

            echo sprintf(
                '<a href="%s" class="%s">%s</a>',
                esc_url(get_category_link($category->term_id)),
                esc_attr($class),
                esc_html($category->name)
            );
        }

        echo '</div>'; // End scroll-container

        // Mobile version - links split into two rows
        echo '<div class="mobile-container">';

        // Prepare all links
        $all_links = [];
        $all_links[] = [
            'url' => get_permalink(get_option('page_for_posts')),
            'class' => $all_class,
            'text' => __('All', 'eks')
        ];

        foreach ($categories as $category) {
            if ($category->slug === 'uncategorized') {
                continue;
            }

            $is_current = $category->term_id == $current_category_id;
            $class = $is_current ? $default_classes . ' current-category' : $default_classes;

            $all_links[] = [
                'url' => get_category_link($category->term_id),
                'class' => $class,
                'text' => $category->name
            ];
        }

        // Split into two groups
        $half = ceil(count($all_links) / 2);
        $group1 = array_slice($all_links, 0, $half);
        $group2 = array_slice($all_links, $half);

        // Render Group 1
        echo '<div class="mobile-row">';
        foreach ($group1 as $link) {
            echo sprintf(
                '<a href="%s" class="%s">%s</a>',
                esc_url($link['url']),
                esc_attr($link['class']),
                esc_html($link['text'])
            );
        }
        echo '</div>';

        // Render Group 2
        echo '<div class="mobile-row">';
        foreach ($group2 as $link) {
            echo sprintf(
                '<a href="%s" class="%s">%s</a>',
                esc_url($link['url']),
                esc_attr($link['class']),
                esc_html($link['text'])
            );
        }
        echo '</div>';

        echo '</div>'; // End mobile-container
        echo '</div>'; // End custom-categories-widget
    }
}