<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class TestimonialWidget extends \Elementor\Widget_Base
{
    public function get_style_depends()
    {
        return ['testimonial-widget']; 
    }

    public function get_script_depends()
    {
        return ['testimonial-widget']; 
    }

    public function get_name()  
    {
        return 'testimonial-widget';
    }

    public function get_title()
    {
        return __('Testimonial', 'travel');
    }

    public function get_icon()
    {
        return 'eicon-carousel';
    }

    protected function _register_controls() {

        // Repeater
        $this->start_controls_section(
            'section_carousel_content',
            [
                'label' => __('Testimonial Items', 'travel'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'text',
            [
                'label'       => __('Name', 'travel'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Testimonial', 'travel'),
                'label_block' => true,
            ]
        );


        $repeater->add_control(
            'testimonial_text',
            [
                'label'       => __('Testimonial text', 'travel'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Testimonial', 'travel'),
                'label_block' => true,
            ]
        );
       

        $repeater->add_control(
            'testimonial_image',
            [
                'label' => __('Image', 'travel'),
                'type'  => Controls_Manager::MEDIA,
                'media_types' => ['image'],
                'default' => [
                    'url' => '',
                ],
            ]
        );

        $repeater->add_control(
            'job_title',
            [
                'label'       => __('Job title', 'travel'),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );


        $repeater->add_control(
            'rating',
            [
                'label'   => __('Rating (stars)', 'travel'),
                'type'    => Controls_Manager::SELECT,
                'default' => '5',
                'options' => [
                    '1' => __('1 Star', 'travel'),
                    '2' => __('2 Stars', 'travel'),
                    '3' => __('3 Stars', 'travel'),
                    '4' => __('4 Stars', 'travel'),
                    '5' => __('5 Stars', 'travel'),
                ],
            ]
        );


        $this->add_control(
            'carousel_items',
            [
                'label'       => __('Items', 'travel'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => '{{{ text }}}',
            ]
        );


        $this->end_controls_section();

        $this->start_controls_section(
            'testimonial_typography_section',
            [
                'label' => __( 'Typography', 'travel' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // Testimonial Text
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'testimonial_text_typo',
                'label'    => __( 'Testimonial Text', 'travel' ),
                'selector' => '{{WRAPPER}} .testimonial-text',
            ]
        );

        // Name
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'testimonial_name_typo',
                'label'    => __( 'Name', 'travel' ),
                'selector' => '{{WRAPPER}} .testimonial-name',
            ]
        );

        // Job Title
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'testimonial_job_typo',
                'label'    => __( 'Job Title', 'travel' ),
                'selector' => '{{WRAPPER}} .testimonial-job',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'star',
                'label'    => __( 'Star', 'travel' ),
                'selector' => '{{WRAPPER}} .star',
            ]
        );

        $this->add_responsive_control(
            'testimonial_box_margin',
            [
                'label'      => __( 'Box Margin', 'travel' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ], 
                'selectors'  => [
                    '{{WRAPPER}} .testimonial-box' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'testimonial_name_margin',
            [
                'label'      => __( 'Name margin', 'travel' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ], 
                'selectors'  => [
                    '{{WRAPPER}} .testimonial-name' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );


        // ===== Colors =====
        $this->add_control(
            'testimonial_text_color',
            [
                'label'     => __( 'Testimonial Text Color', 'travel' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .testimonial-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'testimonial_name_color',
            [
                'label'     => __( 'Name Color', 'travel' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .testimonial-name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'testimonial_job_color',
            [
                'label'     => __( 'Job Title Color', 'travel' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .testimonial-job' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'testimonial_star_color',
            [
                'label'     => __( 'Star Color', 'travel' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .star' => 'color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_section();

    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>

        <div class="carousel-wrapper testimonialCarousel">
            <div class="swiper testimonialSwiper">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <?php foreach ( $s['carousel_items'] as $item ) : 
                    ?>
                        <div class="testimonial-card swiper-slide">
                            <p class="testimonial-text"><?php echo esc_html( $item['testimonial_text'] ); ?></p>
                            <!-- Rating -->
                            <?php if ( ! empty( $item['rating'] ) ) : ?>
                                <div class="testimonial-rating">
                                    <?php for ( $i = 0; $i < intval( $item['rating'] ); $i++ ) : ?>
                                        <span class="star">★</span>
                                    <?php endfor; ?>
                                </div>
                            <?php endif; ?>

                            <div class="testimonial-box">
                                <?php if ( ! empty( $item['testimonial_image']['url'] ) ) : ?>
                                    <div class="testimonial-image">
                                        <img src="<?php echo esc_url( $item['testimonial_image']['url'] ); ?>" alt="<?php echo esc_attr( $item['text'] ); ?>">
                                    </div>
                                <?php endif; ?>
                                <div class="testimonial-user-info">
                                    <h3 class="testimonial-name"><?php echo esc_html( $item['text'] ); ?></h3>
                                    <?php if ( ! empty( $item['job_title'] ) ) : ?>
                                        <p class="testimonial-job"><?php echo esc_html( $item['job_title'] ); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div><!-- End of swiper-wrapper -->
            </div><!-- End of swiper -->

            <!-- navigation buttons -->
             <div class="navigation">
                <div class="carousel-button-prev">
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
                <div class="carousel-button-next">
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
