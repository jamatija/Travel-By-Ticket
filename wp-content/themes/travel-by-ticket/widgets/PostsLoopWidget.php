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
        return __('Posts Loop', 'eks');
    }

    public function get_icon()
    {
        return 'eicon-posts-grid';
    }

    public function get_categories()
    {
        return ['Eks'];
    }

    protected function register_controls()
    {
        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Query Settings', 'eks'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label' => __('Posts Per Page', 'eks'),
                'type' => Controls_Manager::NUMBER,
                'default' => 6,
                'min' => 1,
                'max' => 100,
            ]
        );

        $this->add_control(
            'show_pagination',
            [
                'label' => __('Show Pagination', 'eks'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'eks'),
                'label_off' => __('No', 'eks'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'columns',
            [
                'label' => __('Columns', 'eks'),
                'type' => Controls_Manager::SELECT,
                'default' => '3',
                'options' => [
                    '1' => __('1 Column', 'eks'),
                    '2' => __('2 Columns', 'eks'),
                    '3' => __('3 Columns', 'eks'),
                    '4' => __('4 Columns', 'eks'),
                ],
            ]
        );

        $this->add_control(
            'show_excerpt',
            [
                'label' => __('Show Excerpt', 'eks'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'eks'),
                'label_off' => __('No', 'eks'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label' => __('Excerpt Length', 'eks'),
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
                'label' => __('Show Date', 'eks'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'eks'),
                'label_off' => __('No', 'eks'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_author',
            [
                'label' => __('Show Author', 'eks'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'eks'),
                'label_off' => __('No', 'eks'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'show_categories',
            [
                'label' => __('Show Categories', 'eks'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'eks'),
                'label_off' => __('No', 'eks'),
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

        $paged = max( 0, (int) get_query_var( 'paged' ) );

        var_dump($paged);

        $args = [
            'post_type'           => 'post',
            'post_status'         => 'publish',
            'ignore_sticky_posts' => true,
            'posts_per_page'      => (int) $settings['posts_per_page'],
            'paged'               => $paged,
        ];
        $query = new \WP_Query($args);

        if (!$query->have_posts()) {
            echo '<p class="no-posts-found">' . __('No posts found.', 'eks') . '</p>';
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
                        echo paginate_links([
                            'total'     => (int) $query->max_num_pages,
                            'current'   => max(1, $paged),
                            'prev_text' => __('&laquo; prev', 'travel'),
                            'next_text' => __('next &raquo;', 'travel'),
                            'type'      => 'list',
                            'end_size'  => 2,
                            'mid_size'  => 2,
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