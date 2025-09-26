<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;

class ImageCarouselWidget extends \Elementor\Widget_Base
{
    public function get_style_depends()
    {
        return ['image-carousel-widget']; 
    }

    public function get_script_depends()
    {
        return ['image-carousel-widget']; 
    }

    public function get_name()  
    {
        return 'image-carousel-widget';
    }

    public function get_title()
    {
        return __('Image Carousel', 'travel');
    }

    public function get_icon()
    {
        return 'eicon-carousel';
    }

    protected function _register_controls() {

        // Title and SVG Icon Repeater
        $this->start_controls_section(
            'section_carousel_content',
            [
                'label' => __('Carousel Items', 'travel'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'text',
            [
                'label'       => __('Title', 'travel'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Item Title', 'travel'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'link',
            [
                'label'         => __('Link', 'travel'),
                'type'          => Controls_Manager::URL,
                'placeholder'   => __('https://example.com', 'travel'),
                'show_external' => true, 
                'default'       => [
                    'url'         => '',
                    'is_external' => false,
                    'nofollow'    => false,
                    'custom_attributes' => '',
                ],
            ]
        );

        $repeater->add_control(
            'carousel_item_svg_icon',
            [
                'label' => __('SVG Icon', 'travel'),
                'type'  => Controls_Manager::MEDIA,
                'media_types' => ['image'],
                'default' => [
                    'url' => '',
                ],
            ]
        );

        $this->add_control(
            'carousel_items',
            [
                'label'       => __('Carousel Items', 'travel'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'default'     => [
                    [
                        'carousel_item_title' => __('Sample Title', 'travel'),
                        'carousel_item_svg_icon' => '',
                    ],
                ],
                'title_field' => '{{{ carousel_item_title }}}',
            ]
        );

        $this->end_controls_section();


        /* =========================
            TITLE (card-title)
        ========================= */
        $this->start_controls_section(
            'section_style_title_image',
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
                'selector' => '{{WRAPPER}} .image-card-title',
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label'     => __( 'Text Color', 'travel' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .image-card-title' => 'color: {{VALUE}};',
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
                    '{{WRAPPER}} .image-card-title' =>
                        'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};'.
                        'margin-block-start: {{TOP}}{{UNIT}}; margin-block-end: {{BOTTOM}}{{UNIT}};'.
                        'margin-inline-start: {{LEFT}}{{UNIT}}; margin-inline-end: {{RIGHT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $s = $this->get_settings_for_display();
        ?>

        <div class="carousel-wrapper imageCarousel">
            <div class="swiper imageCarouselSwiper">
                <!-- Additional required wrapper -->
                <div class="swiper-wrapper">
                    <?php foreach ( $s['carousel_items'] as $item ) : 
                        $title = !empty($item['text']) ? $item['text'] : '';  // Get title from repeater
                        $icon_url = !empty($item['carousel_item_svg_icon']['url']) ? $item['carousel_item_svg_icon']['url'] : ''; 
                        $url = !empty($item['link']['url']) ? $item['link']['url'] : '';
                        $is_external = !empty($item['link']['is_external']);
                        $nofollow = !empty($item['link']['nofollow']);
                        $custom_attr = !empty($item['link']['custom_attributes']) ? $item['link']['custom_attributes'] : '';

                        $this->add_render_attribute('link', 'class', 'tw-link'); 
                        
                        $this->remove_render_attribute('link'); 

                        if ($url) {
                            $this->add_render_attribute('link', 'href', esc_url($url));
                        } else {
                            $this->add_render_attribute('link', 'href', '#');
                        }

                        $rel = [];
                        if ($nofollow)   $rel[] = 'nofollow';
                        if ($is_external) $rel[] = 'noopener noreferrer';
                        if (!empty($rel)) {
                            $this->add_render_attribute('link', 'rel', implode(' ', array_unique($rel)));
                        }

                        if ($is_external) {
                            $this->add_render_attribute('link', 'target', '_blank');
                        }

                        if ($custom_attr) {
                            $this->add_render_attribute('link', $custom_attr);
                        }

                    ?>
                        <div class="swiper-slide imageSlide">
                            <?php if ($icon_url) : ?>
                                <div class="carousel-icon">
                                    <img src="<?php echo esc_url($icon_url); ?>" alt="<?php echo esc_attr($title); ?>">
                                </div>
                            <?php endif; ?>

                            <a class="image-card-title" style="display: inline-block;" <?php echo $this->get_render_attribute_string('link'); ?>>
                                <?php echo esc_html($title); ?>
                            </a>
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
