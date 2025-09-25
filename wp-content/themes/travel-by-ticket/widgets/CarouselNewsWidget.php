<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class CarouselNewsWidget extends \Elementor\Widget_Base
{
    public function get_style_depends()
    {
        return ['carousel-news-widget']; 
    }

    public function get_script_depends()
    {
        return ['carousel-news-widget']; 
    }

    public function get_name()  
    {
        return 'carousel-news-widget';
    }

    public function get_title()
    {
        return __('Carousel V2', 'travel');
    }

    public function get_icon()
    {
        return 'eicon-carousel';
    }

    protected function _register_controls() {

        /* =========================
        TITLE (card-title)
        ========================= */
        $this->start_controls_section(
            'section_style_title',
            [
                'label' => __( 'Title', 'travel' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'title_typography',
                'label'    => __( 'Typography', 'travel' ),
                'selector' => '{{WRAPPER}} .card-title',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __( 'Text Color', 'travel' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .card-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        /* TITLE MARGINS */
        $this->add_responsive_control(
            'title_margin',
            [
                'label'      => __( 'Margin', 'travel' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem', '%' ],
                'default'    => [
                    'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .card-title' =>
                        // Shorthand + logičke (pregazi Hello Elementor)
                        'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'.
                        'margin-block-start: {{TOP}}{{UNIT}}; margin-block-end: {{BOTTOM}}{{UNIT}};'.
                        'margin-inline-start: {{LEFT}}{{UNIT}}; margin-inline-end: {{RIGHT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        /* =========================
        PRICE (card-price)
        ========================= */
        $this->start_controls_section(
            'section_style_price',
            [
                'label' => __( 'Price', 'travel' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'price_typography',
                'label'    => __( 'Typography', 'travel' ),
                'selector' => '{{WRAPPER}} .card-price',
            ]
        );

        $this->add_control(
            'price_color',
            [
                'label'     => __( 'Text Color', 'travel' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .card-price' => 'color: {{VALUE}};',
                ],
            ]
        );

        /* PRICE MARGINS */
        $this->add_responsive_control(
            'price_margin',
            [
                'label'      => __( 'Margin', 'travel' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem', '%' ],
                'default'    => [
                    'top' => '0', 'right' => '0', 'bottom' => '0', 'left' => '0', 'unit' => 'px', 'isLinked' => false,
                ],
                'selectors'  => [
                    '{{WRAPPER}} .card-price' =>
                        'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'.
                        'margin-block-start: {{TOP}}{{UNIT}}; margin-block-end: {{BOTTOM}}{{UNIT}};'.
                        'margin-inline-start: {{LEFT}}{{UNIT}}; margin-inline-end: {{RIGHT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();


        /* =========================
        TAG (card-tag)
        ========================= */
        $this->start_controls_section(
            'section_style_tag',
            [
                'label' => __( 'Tag', 'travel' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'tag_typography',
                'label'    => __( 'Typography', 'travel' ),
                'selector' => '{{WRAPPER}} .card-tag',
            ]
        );

        $this->add_control(
            'tag_color',
            [
                'label'     => __( 'Text Color', 'travel' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .card-tag' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

    }


    protected function render()
    {
        $settings = $this->get_settings_for_display();
        
        $posts = get_posts([
            'post_type'        => 'post',
            'post_status'      => 'publish',
            'orderby'          => 'date',
            'order'            => 'DESC',
            'category_name'    => 'popular',
            'numberposts'      => -1,  
            'suppress_filters' => false 
            ]);
        ?>

        <div class="carousel-news-wrapper">
            <!-- Slider main container -->
            <div class="swiper carousel-newsSwiper">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                <?php foreach ( $posts as $p ) : 
                        $from_price = get_field('from_price', $p->ID);
                        $title      = get_the_title( $p );
                        $pos = strpos( $title, ',' );
                        if ( $pos !== false ) {
                            $main_title = trim( substr( $title, 0, $pos + 1 ) ); 
                            $tag_part   = trim( substr( $title, $pos + 1 ) );
                        } else {
                            $main_title = trim( $title );
                            $tag_part   = '';
                        }
                    ?>
                    <div class="swiper-slide">
                        <a href="<?php echo esc_url( get_permalink( $p ) ); ?>" class="card">
                        <?php if ( has_post_thumbnail( $p ) ) : ?>
                            <figure class="card-media">
                            <?php echo get_the_post_thumbnail( $p, 'medium' ); ?>
                            </figure>
                        <?php endif; ?>

                        <div class="card-heading">
                            <h3 class="card-title"><?php echo esc_html( $main_title ); if ( $tag_part ) : ?> <span class="card-tag"><?php echo esc_html( $tag_part ); ?></span>
                        <?php endif; ?></h3>

                        </div>
                        <p class="card-price">
                            <?php echo esc_html( sprintf( __('from %s €', 'travel'), $from_price ) ); ?>
                        </p>
                        </a>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- navigation buttons -->
            <div class="navigation">
                <div class="carousel-news-button-prev">
                    <svg width="101" height="120" viewBox="0 0 101 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g>
                        <path d="M30.7138 21.4311C31.4617 17.6917 34.745 15 38.5584 15H77.2416C82.2899 15 86.0763 19.6186 85.0862 24.5689L70.2862 98.5689C69.5383 102.308 66.255 105 62.4416 105H23.7584C18.7101 105 14.9237 100.381 15.9138 95.4311L30.7138 21.4311Z" fill="white"/>
                        </g>
                        <path d="M46 59.0691C46 59.2534 46.0614 59.4113 46.1842 59.5429L54.8214 68.8026C54.9441 68.9342 55.0915 69 55.2634 69C55.4352 69 55.5826 68.9342 55.7053 68.8026C55.8281 68.6709 55.8895 68.513 55.8895 68.3287C55.8895 68.1445 55.8281 67.9865 55.7053 67.8549L47.5101 59.0691L55.8343 50.1451C55.9448 50.0135 56 49.8555 56 49.6713C56 49.487 55.9448 49.3291 55.8343 49.1974C55.7729 49.1316 55.7023 49.0823 55.6225 49.0494C55.5427 49.0165 55.4659 49 55.3923 49C55.3063 49 55.2235 49.0165 55.1436 49.0494C55.0638 49.0823 54.9932 49.1316 54.9319 49.1974L46.1842 58.5953C46.0614 58.7269 46 58.8848 46 59.0691Z" fill="#F4B821"/>
                        <defs>
                        <filter id="filter0_d_145_128" x="0.755737" y="0" width="99.4885" height="120" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                        <feOffset/>
                        <feGaussianBlur stdDeviation="7.5"/>
                        <feComposite in2="hardAlpha" operator="out"/>
                        <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.12 0"/>
                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_145_128"/>
                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_145_128" result="shape"/>
                        </filter>
                        </defs>
                    </svg>

                </div>
                <div class="carousel-news-button-next">
                    <svg width="101" height="120" viewBox="0 0 101 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g>
                        <path d="M30.7138 21.4311C31.4617 17.6917 34.745 15 38.5584 15H77.2416C82.2899 15 86.0763 19.6186 85.0862 24.5689L70.2862 98.5689C69.5383 102.308 66.255 105 62.4416 105H23.7584C18.7101 105 14.9237 100.381 15.9138 95.4311L30.7138 21.4311Z" fill="white"/>
                        </g>
                        <path d="M56 59.0691C56 59.2534 55.9386 59.4113 55.8158 59.5429L47.1786 68.8026C47.0559 68.9342 46.9085 69 46.7366 69C46.5648 69 46.4174 68.9342 46.2947 68.8026C46.1719 68.6709 46.1105 68.513 46.1105 68.3287C46.1105 68.1445 46.1719 67.9865 46.2947 67.8549L54.4899 59.0691L46.1657 50.1451C46.0552 50.0135 46 49.8555 46 49.6713C46 49.487 46.0552 49.3291 46.1657 49.1974C46.2271 49.1316 46.2977 49.0823 46.3775 49.0494C46.4573 49.0165 46.5341 49 46.6077 49C46.6937 49 46.7765 49.0165 46.8564 49.0494C46.9362 49.0823 47.0068 49.1316 47.0681 49.1974L55.8158 58.5953C55.9386 58.7269 56 58.8848 56 59.0691Z" fill="#F4B821"/>
                        <defs>
                        <filter id="filter0_d_145_131" x="0.755737" y="0" width="99.4886" height="120" filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                        <feFlood flood-opacity="0" result="BackgroundImageFix"/>
                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha"/>
                        <feOffset/>
                        <feGaussianBlur stdDeviation="7.5"/>
                        <feComposite in2="hardAlpha" operator="out"/>
                        <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.12 0"/>
                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_145_131"/>
                        <feBlend mode="normal" in="SourceGraphic" in2="effect1_dropShadow_145_131" result="shape"/>
                        </filter>
                        </defs>
                    </svg>
                </div>
            </div>
        </div>

        <?php

    }
}
