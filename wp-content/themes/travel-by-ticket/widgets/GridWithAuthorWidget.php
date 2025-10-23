<?php
use Elementor\Group_Control_Typography;
use Elementor\Controls_Manager;

class GridWithAuthorWidget extends \Elementor\Widget_Base
{
    public function get_style_depends()
    {
        return ['grid-with-author']; 
    }

    public function get_name()  
    {
        return 'grid-with-author';
    }

    public function get_title()
    {
        return __('Grid with author', 'travel');
    }

    public function get_icon()
    {
        return 'eicon-container-grid';
    }

    protected function _register_controls() {

        /* =========================
                Select source
        ========================= */
        $this->start_controls_section(
            'section_cpt_taxonomy',
            [
                'label' => __( 'Select Content', 'travel' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'cpt',
            [
                'label'   => __( 'Select Post Type', 'travel' ),
                'type'    => Controls_Manager::SELECT,
                'options' => $this->get_post_type_options(), 
                'default' => 'post',
            ]
        );

        $this->add_control(
            'taxonomy',
            [
                'label'   => __( 'Include Categories', 'travel' ),
                'type'    => Controls_Manager::SELECT2,
                'options' => $this->get_category_options(), 
                'default' => '',
                'multiple' => true,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'exclude_categories',
            [
                'label'   => __( 'Exclude Categories', 'travel' ),
                'type'    => Controls_Manager::SELECT2,
                'options' => $this->get_category_options(), 
                'default' => '',
                'multiple' => true,
                'label_block' => true,
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'   => __( 'Order By', 'travel' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'date'       => __( 'Date', 'travel' ),
                    'title'      => __( 'Title', 'travel' ),
                    'rand'       => __( 'Random', 'travel' ),
                    'menu_order' => __( 'Menu Order', 'travel' ),
                ],
                'default' => 'date',
            ]
        );

        $this->add_control(
            'order',
            [
                'label'   => __( 'Order', 'travel' ),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'ASC'  => __( 'Ascending', 'travel' ),
                    'DESC' => __( 'Descending', 'travel' ),
                ],
                'default' => 'DESC',
            ]
        );

        $this->add_control(
            'excerpt_length',
            [
                'label'       => __( 'Excerpt Length', 'travel' ),
                'type'        => Controls_Manager::NUMBER,
                'default'     => 20,
                'min'         => 10,
                'max'         => 500,
                'step'        => 10,
                'description' => __( 'Maximum number of characters to show in the excerpt.', 'travel' ),
            ]
        );

        $this->add_control(
        'all_news_mobile_enable',
        [
            'label'        => __( 'Show “All news” on 3rd card (mobile)', 'travel' ),
            'type'         => Controls_Manager::SWITCHER,
            'label_on'     => __( 'Yes', 'travel' ),
            'label_off'    => __( 'No', 'travel' ),
            'return_value' => 'yes',
            'default'      => 'yes',
                ]
        );

        $this->add_control(
            'all_news_mobile_text',
            [
                'label'       => __( 'All news (mobile) text', 'travel' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'All news', 'travel' ),
                'placeholder' => __( 'All news', 'travel' ),
                'condition'   => [ 'all_news_mobile_enable' => 'yes' ],
            ]
        );

        $this->add_control(
            'all_news_mobile_link',
            [
                'label'       => __( 'All news URL', 'travel' ),
                'type'        => Controls_Manager::URL,
                'default'     => [ 'url' => '#' ],
                'show_external' => true,
                'condition'   => [ 'all_news_mobile_enable' => 'yes' ],
            ]
        );



        $this->end_controls_section();

        /* =========================
                Static Card (4th)
        ========================= */
        $this->start_controls_section(
            'section_static_card',
            [
                'label' => __( 'Static Card (4th)', 'travel' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'static_image',
            [
                'label'   => __( 'Image', 'travel' ),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'static_title',
            [
                'label'   => __( 'Title', 'travel' ),
                'type'    => Controls_Manager::TEXT,
                'default' => 'Static Card Title',
            ]
        );

        $this->add_control(
            'static_text',
            [
                'label'   => __( 'Text', 'travel' ),
                'type'    => Controls_Manager::TEXTAREA,
                'default' => 'This is static card content that always appears as the 4th card.',
                'rows'    => 3,
            ]
        );

        $this->add_control(
            'static_link_text',
            [
                'label'       => __( 'Link Text', 'travel' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => __( 'Enter link text', 'travel' ),
                'condition'   => [
                    'static_link[url]!' => '', 
                ],
            ]
        );

        $this->add_control(
            'static_link_text_mobile',
            [
                'label'       => __( 'Mobile Link Text', 'travel' ),
                'type'        => Controls_Manager::TEXT,
                'placeholder' => __( 'Enter shorter text for mobile', 'travel' ),
            ]
        );

        $this->add_control(
            'static_link',
            [
                'label'   => __( 'Link', 'travel' ),
                'type'    => Controls_Manager::URL,
                'default' => [
                    'url' => '#',
                ],
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

        /* =========================
             Static card styles
        ========================= */
        $this->start_controls_section(
            'section_static_text_style',
            [
                'label' => __( 'Static Card Styling', 'travel' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'grid-static-title',
            [
                'label' => __( 'Color', 'travel' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#666666',
                'selectors' => [
                    '{{WRAPPER}} .grid-static-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography_static_title',
                'selector' => '{{WRAPPER}} .grid-static-title',
            ]
        );

        $this->add_responsive_control(
            'text_margin_title',
            [
                'label' => __( 'Margin', 'travel' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .grid-static-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

         $this->add_control(
            'grid-static-text',
            [
                'label' => __( 'Color', 'travel' ),
                'type' => Controls_Manager::COLOR,
                'default' => '#666666',
                'selectors' => [
                    '{{WRAPPER}} .grid-static-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'text_typography_static',
                'selector' => '{{WRAPPER}} .grid-static-text',
            ]
        );

        $this->add_responsive_control(
            'text_margin_text_static',
            [
                'label' => __( 'Margin', 'travel' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%', 'em' ],
                'selectors' => [
                    '{{WRAPPER}} .grid-static-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        /* =========================
                STYLE TAB - Grid Gap
        ========================= */
        $this->start_controls_section(
            'section_grid_style',
            [
                'label' => __( 'Grid', 'travel' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'grid_gap',
            [
                'label' => __( 'Gap', 'travel' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'size' => 24,
                ],
                'selectors' => [
                    '{{WRAPPER}} .blog-grid' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    public function get_taxonomy_options() {
        $taxonomies = get_taxonomies(['public' => true], 'objects');
        
        $options = [];

        foreach ($taxonomies as $taxonomy) {
            $terms = get_terms([
                'taxonomy' => $taxonomy->name, 
                'hide_empty' => false, 
            ]);

            if ($terms && !is_wp_error($terms)) {
                foreach ($terms as $term) {
                    $options[$term->term_id] = $term->name;
                }
            }
        }

        return $options;
    }

    public function get_post_type_options() {
        $post_types = get_post_types(['public' => true], 'objects');

        $options = [];
        foreach ($post_types as $post_type) {
            $options[$post_type->name] = $post_type->labels->singular_name;
        }

        return $options;
    }

    public function get_category_options() {
        $taxonomies = get_taxonomies(['public' => true], 'objects');
        
        $options = [];

        foreach ($taxonomies as $taxonomy) {
            $terms = get_terms([
                'taxonomy' => $taxonomy->name, 
                'hide_empty' => false, 
            ]);

            if ($terms && !is_wp_error($terms)) {
                foreach ($terms as $term) {
                    $options[$term->term_id] = $term->name;
                }
            }
        }

        return $options;
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $target   = $settings['static_link']['is_external'] ? ' target="_blank"' : '';
        $nofollow = $settings['static_link']['nofollow'] ? ' rel="nofollow"' : '';
        
        $args = [
            'post_type'      => $settings['cpt'],
            'posts_per_page' => 3,
            'orderby'        => $settings['orderby'],
            'order'          => $settings['order'],
            'post_status'    => 'publish',
        ];

        if (!empty($settings['taxonomy'])) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'category',
                    'field'    => 'term_id',
                    'terms'    => $settings['taxonomy'],
                    'operator' => 'IN',
                ],
            ];
        }

        if (!empty($settings['exclude_categories'])) {
            if (!isset($args['tax_query'])) {
                $args['tax_query'] = [];
            }
            $args['tax_query'][] = [
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => $settings['exclude_categories'],
                'operator' => 'NOT IN',
            ];
        }

        $query = new \WP_Query($args);
    ?>
        <div class="blog-grid">
            <?php 
            if ($query->have_posts()) : 
                $i = 0;
                while ($query->have_posts()) : $query->the_post(); 
                $i++;

                $raw_excerpt = has_excerpt() ? get_the_excerpt() : wp_strip_all_tags( get_the_content() );
                $max_chars   = !empty( $settings['excerpt_length'] ) ? intval( $settings['excerpt_length'] ) : 20;

                if ( strlen( $raw_excerpt ) > $max_chars ) {
                    $excerpt = substr( $raw_excerpt, 0, $max_chars ) . '...';
                } else {
                    $excerpt = $raw_excerpt;
                }
            ?>
                    <div class="grid-post-card">
                        <a href="<?php echo get_post_permalink(); ?>">
                            <?php if (has_post_thumbnail()) : ?>
                                <img class="grid-post-image" src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large'); ?>" alt="<?php the_title(); ?>">
                            <?php endif; ?>
                        </a>
                        <div class="post-card-info">
                            <span class="grid-post-date"><?php echo get_the_date('j F, Y'); ?></span>
                            <a href="<?php echo get_post_permalink(); ?>">
                                <h3 class="grid-post-title"><?php the_title(); ?></h3>
                            </a>
                            <p class="grid-post-text"><?php echo $excerpt ?></p>
                            <?php
                        if ( $i === 3 && !empty($settings['all_news_mobile_enable']) && $settings['all_news_mobile_enable'] === 'yes' && !empty($settings['all_news_mobile_link']['url']) ) :
                            $all_news_target   = !empty($settings['all_news_mobile_link']['is_external']) ? ' target="_blank"' : '';
                            $all_news_nofollow = !empty($settings['all_news_mobile_link']['nofollow']) ? ' rel="nofollow"' : '';
                            $all_news_text     = !empty($settings['all_news_mobile_text']) ? $settings['all_news_mobile_text'] : __( 'All news', 'travel' );
                        ?>
                            <a class="btn-all-news-mobile" href="<?php echo esc_url( $settings['all_news_mobile_link']['url'] ); ?>"<?php echo $all_news_target . $all_news_nofollow; ?>>
                                <?php echo esc_html( $all_news_text ); ?>
                            </a>
                        <?php endif; ?>
                        </div>
                    </div>
            <?php 
                endwhile;
            endif;
            wp_reset_postdata();

            ?>
            <div class="grid-post-card grid-post-card--static">
                <?php if (!empty($settings['static_image']['url'])) : ?>
                    <img class="grid-post-image" src="<?php echo esc_url($settings['static_image']['url']); ?>" alt="<?php echo esc_attr($settings['static_title']); ?>">
                <?php endif; ?>
                <h3 class="grid-static-title"><?php echo esc_html($settings['static_title']); ?></h3>
                <p class="grid-static-text"><?php echo esc_html($settings['static_text']); ?></p>
                <a class="grid-view-map" href="<?php echo esc_url( $settings['static_link']['url'] ); ?>"<?php echo $target . $nofollow; ?>>
                     <span class="link-text-desktop">
                        <?php echo esc_html( $settings['static_link_text'] ?: __( 'View Map', 'travel' ) ); ?>
                    </span>

                    <?php if ( !empty( $settings['static_link_text_mobile'] ) ) : ?>
                        <span class="link-text-mobile">
                            <?php echo esc_html( $settings['static_link_text_mobile'] ); ?>
                        </span>
                    <?php endif; ?>
                </a>
            </div>
        </div>
    <?php
    }
}