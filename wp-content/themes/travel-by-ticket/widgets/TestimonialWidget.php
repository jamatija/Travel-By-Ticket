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
                            <svg width="58" height="40" viewBox="0 0 58 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10.626 40C6.98558 40 4.2799 39.1144 2.50891 37.3432C0.836302 35.572 0 33.3087 0 30.5535V28.0443C0 25.6827 0.34436 23.2226 1.03308 20.6642C1.82019 18.1058 2.85327 15.5965 4.13232 13.1365C5.41137 10.6765 6.93639 8.31487 8.70738 6.05165C10.4784 3.78843 12.4461 1.77121 14.6107 0H25.9746C22.9245 3.05043 20.3664 6.05165 18.3003 9.00369C16.3325 11.8573 14.8567 15.0553 13.8728 18.5978C16.4309 19.0898 18.3003 20.2214 19.4809 21.9926C20.6616 23.6654 21.2519 25.6335 21.2519 27.8967V30.5535C21.2519 33.3087 20.3664 35.572 18.5954 37.3432C16.9228 39.1144 14.2663 40 10.626 40ZM42.6514 40C39.011 40 36.3053 39.1144 34.5344 37.3432C32.8617 35.572 32.0254 33.3087 32.0254 30.5535V28.0443C32.0254 25.6827 32.3698 23.2226 33.0585 20.6642C33.8456 18.1058 34.8787 15.5965 36.1578 13.1365C37.4368 10.6765 38.9618 8.31487 40.7328 6.05165C42.5038 3.78843 44.4716 1.77121 46.6361 0H58C54.95 3.05043 52.3919 6.05165 50.3257 9.00369C48.3579 11.8573 46.8821 15.0553 45.8982 18.5978C48.4563 19.0898 50.3257 20.2214 51.5064 21.9926C52.687 23.6654 53.2774 25.6335 53.2774 27.8967V30.5535C53.2774 33.3087 52.3919 35.572 50.6209 37.3432C48.9483 39.1144 46.2918 40 42.6514 40Z" fill="#EDE2F3"/>
                            </svg>
                            <div class="testimonial-info">
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
                            <svg class="bottom-icon" width="58" height="40" viewBox="0 0 58 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M47.374 4.74365e-06C51.0144 4.4254e-06 53.7201 0.885617 55.4911 2.65683C57.1637 4.42805 58 6.69127 58 9.4465L58 11.9557C58 14.3173 57.6556 16.7774 56.9669 19.3358C56.1798 21.8942 55.1467 24.4035 53.8677 26.8635C52.5886 29.3235 51.0636 31.6851 49.2926 33.9483C47.5216 36.2116 45.5539 38.2288 43.3893 40L32.0254 40C35.0755 36.9496 37.6336 33.9483 39.6997 30.9963C41.6675 28.1427 43.1433 24.9447 44.1272 21.4022C41.5691 20.9102 39.6997 19.7786 38.5191 18.0074C37.3384 16.3346 36.7481 14.3665 36.7481 12.1033L36.7481 9.4465C36.7481 6.69127 37.6336 4.42805 39.4046 2.65684C41.0772 0.885618 43.7337 5.0619e-06 47.374 4.74365e-06ZM15.3486 7.5434e-06C18.989 7.22515e-06 21.6947 0.885619 23.4656 2.65684C25.1382 4.42805 25.9745 6.69127 25.9745 9.44651L25.9745 11.9557C25.9745 14.3173 25.6302 16.7774 24.9415 19.3358C24.1544 21.8942 23.1213 24.4035 21.8422 26.8635C20.5632 29.3235 19.0382 31.6851 17.2672 33.9484C15.4962 36.2116 13.5284 38.2288 11.3639 40L0 40C3.05004 36.9496 5.60814 33.9483 7.6743 30.9963C9.64207 28.1427 11.1179 24.9447 12.1018 21.4022C9.54368 20.9102 7.6743 19.7786 6.49364 18.0074C5.31297 16.3346 4.72264 14.3665 4.72264 12.1033L4.72264 9.44651C4.72264 6.69127 5.60813 4.42805 7.37912 2.65684C9.05173 0.885621 11.7082 7.86165e-06 15.3486 7.5434e-06Z" fill="#EDE2F3"/>
                            </svg>

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
