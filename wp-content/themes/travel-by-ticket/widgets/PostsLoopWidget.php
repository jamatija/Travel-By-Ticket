<?php
if (!defined('ABSPATH')) {
    exit;
}
use Elementor\Group_Control_Typography;
use Elementor\Controls_Manager;

class PostsLoopWidget extends \Elementor\Widget_Base
{
    public function get_name()
    {
        return 'posts_loop_widget';
    }

    public function get_style_depends()
    {
        return ['posts-loop-widget'];
    }

    public function get_title()
    {
        return __('Posts Loop', 'travel');
    }

    public function get_icon()
    {
        return 'eicon-posts-grid';
    }

    public function get_categories()
    {
        return ['travel'];
    }

    protected function register_controls()
    {
        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Query Settings', 'travel'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label' => __('Show Pagination', 'travel'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'travel'),
                'label_off' => __('No', 'travel'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => __('Columns', 'travel'),
                'type' => Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '1' => __('1 Column', 'travel'),
                    '2' => __('2 Columns', 'travel'),
                    '3' => __('3 Columns', 'travel'),
                    '4' => __('4 Columns', 'travel'),
                ],
            ]
        );

        $this->add_control(
            'show_excerpt',
            [
                'label' => __('Show Excerpt', 'travel'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'travel'),
                'label_off' => __('No', 'travel'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label' => __('Excerpt Length', 'travel'),
                'type' => Controls_Manager::NUMBER,
                'default' => 20,
                'condition' => [
                    'show_excerpt' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'show_date',
            [
                'label' => __('Show Date', 'travel'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'travel'),
                'label_off' => __('No', 'travel'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_author',
            [
                'label' => __('Show Author', 'travel'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'travel'),
                'label_off' => __('No', 'travel'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_categories',
            [
                'label' => __('Show Categories', 'travel'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'travel'),
                'label_off' => __('No', 'travel'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();


           /* =========================
                STYLE TAB - Card Info Padding
        ========================= */
        $this->start_controls_section(
            'section_card_info_style',
            [
                'label' => __( 'Card Info', 'travel' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'card_info_padding',
            [
                'label' => __( 'Padding', 'travel' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'default' => [
                    'top' => '20',
                    'right' => '20',
                    'bottom' => '20',
                    'left' => '20',
                    'unit' => 'px',
                ],
                'selectors' => [
                    '{{WRAPPER}} .post-card-info' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* =========================
                STYLE TAB - Date
        ========================= */
        $this->start_controls_section(
            'section_date_style',
            [
                'label' => __( 'Date', 'travel' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'date_color',
            [
                'label' => __( 'Color', 'travel' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#8B3DAF',
                'selectors' => [
                    '{{WRAPPER}} .grid-post-date' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'date_typography',
                'selector' => '{{WRAPPER}} .grid-post-date',
            ]
        );

        $this->add_responsive_control(
            'date_margin',
            [
                'label' => __( 'Margin', 'travel' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .grid-post-date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* =========================
                STYLE TAB - Title
        ========================= */
        $this->start_controls_section(
            'section_title_style',
            [
                'label' => __( 'Title', 'travel' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Color', 'travel' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#2D1B4E',
                'selectors' => [
                    '{{WRAPPER}} .grid-post-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typography',
                'selector' => '{{WRAPPER}} .grid-post-title',
            ]
        );

        $this->add_responsive_control(
            'title_margin',
            [
                'label' => __( 'Margin', 'travel' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .grid-post-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* =========================
                STYLE TAB - Text
        ========================= */
        $this->start_controls_section(
            'section_text_style',
            [
                'label' => __( 'Text', 'travel' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label' => __( 'Color', 'travel' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#666666',
                'selectors' => [
                    '{{WRAPPER}} .grid-post-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography',
                'selector' => '{{WRAPPER}} .grid-post-text',
            ]
        );

        $this->add_responsive_control(
            'text_margin',
            [
                'label' => __( 'Margin', 'travel' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .grid-post-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $paged = max( 1, (int) get_query_var('paged'), (int) get_query_var('page') );

        
        if ( is_home() || is_archive() || is_search() ) {
            global $wp_query;
            $query = $wp_query;
        } else {
            $query = new WP_Query([
                'post_type'           => 'post',
                'posts_per_page'      => 7,
                'paged'               => $paged,
                'ignore_sticky_posts' => true,
                'no_found_rows'       => false,
            ]);
        }

    
        if (!$query->have_posts()) {
            echo '<p class="no-posts-found">' . __('No posts found.', 'travel') . '</p>';
            return;
        }

        $columns_class = 'posts-grid-' . $settings['columns'];
        ?>

        <div class="posts-loop-widget">
            <div class="<?php echo esc_attr($columns_class); ?>">
               <div class="posts-grid split-rows">
                    <?php
                    $i = 0;
                    echo '<div class="first-row">';
                    while ($query->have_posts()) {
                        $query->the_post();
                        $i++;?>
                        <?php
                        if ($i === 4) {
                            echo '</div><div class="other-rows">'; 
                        }

                        $this->render_post_item($settings, $i);
                    }
                    echo '</div>';
                    ?>
                </div>
            </div>

            <?php if ($settings['show_pagination'] === 'yes' && $query->max_num_pages > 1) : ?>
                <div class="posts-pagination">
                    <?php
                    $is_mobile = wp_is_mobile();
                    echo paginate_links([
                        'total'     => $query->max_num_pages,
                        'current'   => max(1, $paged),
                        'prev_text' => $is_mobile ? __('<svg width="7" height="13" viewBox="0 0 7 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M-3.9879e-07 6.54492C-3.97361e-07 6.66469 0.0429707 6.76736 0.128913 6.85291L6.17495 12.8717C6.2609 12.9572 6.36403 13 6.48435 13C6.60467 13 6.7078 12.9572 6.79374 12.8717C6.87968 12.7861 6.92265 12.6834 6.92265 12.5637C6.92265 12.4439 6.87968 12.3412 6.79374 12.2557L1.05709 6.54492L6.88398 0.744324C6.96133 0.658769 7 0.556104 7 0.436328C7 0.316552 6.96133 0.213886 6.88398 0.128332C6.84101 0.0855545 6.79159 0.0534715 6.73573 0.0320829C6.67986 0.0106943 6.62615 4.4581e-09 6.57459 5.07302e-09C6.51443 5.79041e-09 6.45641 0.0106943 6.40055 0.0320829C6.34469 0.0534715 6.29527 0.0855545 6.2523 0.128332L0.128913 6.23692C0.0429707 6.32247 -4.00218e-07 6.42514 -3.9879e-07 6.54492Z" fill="#480E66"/>
                                                </svg>', 'travel') : __('<svg width="7" height="13" viewBox="0 0 7 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M-3.9879e-07 6.54492C-3.97361e-07 6.66469 0.0429707 6.76736 0.128913 6.85291L6.17495 12.8717C6.2609 12.9572 6.36403 13 6.48435 13C6.60467 13 6.7078 12.9572 6.79374 12.8717C6.87968 12.7861 6.92265 12.6834 6.92265 12.5637C6.92265 12.4439 6.87968 12.3412 6.79374 12.2557L1.05709 6.54492L6.88398 0.744324C6.96133 0.658769 7 0.556104 7 0.436328C7 0.316552 6.96133 0.213886 6.88398 0.128332C6.84101 0.0855545 6.79159 0.0534715 6.73573 0.0320829C6.67986 0.0106943 6.62615 4.4581e-09 6.57459 5.07302e-09C6.51443 5.79041e-09 6.45641 0.0106943 6.40055 0.0320829C6.34469 0.0534715 6.29527 0.0855545 6.2523 0.128332L0.128913 6.23692C0.0429707 6.32247 -4.00218e-07 6.42514 -3.9879e-07 6.54492Z" fill="#480E66"/>
                                                </svg>
                                                prev', 'travel'),
                        'next_text' => $is_mobile ? __('<svg width="7" height="13" viewBox="0 0 7 13" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M7 6.45508C7 6.33531 6.95703 6.23264 6.87109 6.14709L0.825046 0.128331C0.739103 0.042777 0.635972 -2.77993e-08 0.515653 -2.25399e-08C0.395334 -1.72806e-08 0.292203 0.042777 0.206261 0.128331C0.120319 0.213885 0.0773475 0.316551 0.0773475 0.436327C0.0773475 0.556104 0.120319 0.658769 0.206261 0.744324L5.94291 6.45508L0.116022 12.2557C0.038674 12.3412 -2.43081e-08 12.4439 -1.90725e-08 12.5637C-1.38369e-08 12.6834 0.038674 12.7861 0.116022 12.8717C0.158993 12.9144 0.20841 12.9465 0.264273 12.9679C0.320135 12.9893 0.373849 13 0.425414 13C0.485574 13 0.543585 12.9893 0.599448 12.9679C0.65531 12.9465 0.704727 12.9144 0.747698 12.8717L6.87109 6.76308C6.95703 6.67753 7 6.57486 7 6.45508Z" fill="#480E66"/> </svg>', 'travel') : __('next <svg width="7" height="13" viewBox="0 0 7 13" fill="none" xmlns="http://www.w3.org/2000/svg"> <path d="M7 6.45508C7 6.33531 6.95703 6.23264 6.87109 6.14709L0.825046 0.128331C0.739103 0.042777 0.635972 -2.77993e-08 0.515653 -2.25399e-08C0.395334 -1.72806e-08 0.292203 0.042777 0.206261 0.128331C0.120319 0.213885 0.0773475 0.316551 0.0773475 0.436327C0.0773475 0.556104 0.120319 0.658769 0.206261 0.744324L5.94291 6.45508L0.116022 12.2557C0.038674 12.3412 -2.43081e-08 12.4439 -1.90725e-08 12.5637C-1.38369e-08 12.6834 0.038674 12.7861 0.116022 12.8717C0.158993 12.9144 0.20841 12.9465 0.264273 12.9679C0.320135 12.9893 0.373849 13 0.425414 13C0.485574 13 0.543585 12.9893 0.599448 12.9679C0.65531 12.9465 0.704727 12.9144 0.747698 12.8717L6.87109 6.76308C6.95703 6.67753 7 6.57486 7 6.45508Z" fill="#480E66"/> </svg>', 'travel'),
                        'type'      => 'list',
                        'mid_size'  => $is_mobile ? 1 : 2,
                        'end_size'  => $is_mobile ? 0 : 2,
                        'base'      => str_replace(999999, '%#%', esc_url( get_pagenum_link(999999) )),
                    ]);
                    ?>
                </div>
            <?php endif; ?>

        </div>

        <?php
        wp_reset_postdata();
    }

    protected function render_post_item($settings, $i)
    {
    ?>
       <article>
           <a class="article-wrapper" href="<?php echo get_permalink(); ?>">
            <div class="grid-post-card">
                    <?php if (has_post_thumbnail()) : ?>
                        <img class="grid-post-image" src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>" alt="<?php the_title(); ?>">
                    <?php endif; ?>
                <div class="post-card-info">
                        <?php if ($i < 4): ?>
                            <span class="grid-post-date">
                                <?php echo 'From the blog, ' . get_the_date('d.m.Y'); ?>
                            </span>
                        <?php else: ?>
                            <span class="grid-post-date">
                                <?php echo get_the_date('j F, Y'); ?>
                            </span>
                        <?php endif; ?>

                    <h3 class="grid-post-title"><?php the_title(); ?></h3>
                    
                    <?php if (!empty($settings['show_author']) && $settings['show_author'] === 'yes') : ?>
                        <div class="post-meta">
                            <span class="post-author">
                                <?php echo get_avatar(get_the_author_meta('ID'), 24); ?>
                                <?php echo esc_html(get_the_author()); ?>
                            </span>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (!empty($settings['show_excerpt']) && $settings['show_excerpt'] === 'yes') : ?>
                        <p class="grid-post-text">
                            <?php echo esc_html(wp_trim_words(get_the_excerpt(), !empty($settings['excerpt_length']) ? $settings['excerpt_length'] : 30, '...')); ?>
                        </p>
                    <?php else : ?>
                        <p class="grid-post-text"><?php echo esc_html(wp_trim_words(get_the_excerpt(), $settings['excerpt_length'], '...')); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php echo ($i < 4) ? '<button class="grid-row-button" href="#">Read more</button>' : ''; ?>
        </a>
       </article>
        <?php
    }
}