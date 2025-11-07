<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;

class ShapedImageWidget extends \Elementor\Widget_Base
{
    public function get_style_depends()
    {
        return ['shaped-image-widget']; 
    }

    public function get_name()  
    {
        return 'shaped-image-widget';
    }

    public function get_title()
    {
        return __('Shaped Image', 'travel');
    }

    public function get_icon()
    {
        return 'eicon-image';
    }

    public function get_categories()
    {
        return ['general'];
    }

    protected function _register_controls() {

       /* =========================
           CONTENT - IMAGE
        ========================= */
        $this->start_controls_section(
            'section_content_image',
            [
                'label' => __( 'Image', 'travel' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'image_source',
            [
                'label'   => __( 'Image Source', 'travel' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'static',
                'options' => [
                    'static'           => __( 'Static Image', 'travel' ),
                    'featured'         => __( 'Featured Image', 'travel' ),
                ],
            ]
        );

        $this->add_control(
            'image',
            [
                'label'   => __( 'Choose Image', 'travel' ),
                'type'    => Controls_Manager::MEDIA,
            ]
        );

        $this->end_controls_section();
    }

    protected function render(){
        $settings = $this->get_settings_for_display();
        
        // Get image URL
        $image_url = '';

        if($settings['image_source'] === "featured"){
            if ( has_post_thumbnail() ) {
                $image_id = get_post_thumbnail_id();
                $image_url = wp_get_attachment_image_url( $image_id, 'full' );
            }
        }

        if ( ! empty( $settings['image']['url'] ) && ! empty($image_url) ) {
            $image_url = $settings['image']['url'];
        }

        // Get masks for desktop and mobile
        $desktop_mask = $this->get_desktop_mask_svg();
        $mobile_mask = $this->get_mobile_mask_svg();

        ?>
        <style>
            .shaped-<?php echo $this->get_id(); ?> {
                --mask-svg: url('<?php echo $desktop_mask; ?>');
            }
            @media (max-width: 768px) {
                .shaped-<?php echo $this->get_id(); ?> {
                    --mask-svg: url('<?php echo $mobile_mask; ?>');
                }
            }
        </style>
        <div class="shaped shaped-<?php echo $this->get_id(); ?>" style="--img:url('<?php echo esc_url($image_url); ?>')"></div>
        <?php
    }

    /**
     * Get desktop SVG mask as data URI
     */
    protected function get_desktop_mask_svg() {
        $svg = '<svg viewBox="0 0 622 434" xmlns="http://www.w3.org/2000/svg"><path d="M584.938 0.0297362L447.443 0C441.271 25.5731 418.193 44.6043 390.643 44.6043C363.092 44.6043 340.014 25.6029 333.842 0H264.919C249.564 0 235.669 9.03981 229.467 23.0456L71.2911 380.653L0 380.742V434H162.129C168.301 408.427 191.379 389.396 218.93 389.396C246.48 389.396 269.558 408.397 275.73 434H367.725C383.081 434 396.975 424.96 403.177 410.954L561.324 53.4062H622V0H553.364L584.938 0.0297362Z" fill="white"/></svg>';
        
        return 'data:image/svg+xml;utf8,' . rawurlencode($svg);
    }

    /**
     * Get mobile SVG mask as data URI
     */
    protected function get_mobile_mask_svg() {
        $svg = '<svg viewBox="0 0 440 393" xmlns="http://www.w3.org/2000/svg"><path opacity="0.8" d="M462.202 0.0269028L337.808 0C332.224 23.1364 311.346 40.3542 286.42 40.3542C261.495 40.3542 240.616 23.1633 235.032 0H172.676C158.784 0 146.213 8.17845 140.603 20.8497L-2.50187 344.383L-67 344.463V392.646H79.681C85.2649 369.51 106.144 352.292 131.069 352.292C155.994 352.292 176.873 369.483 182.457 392.646H265.687C279.579 392.646 292.15 384.468 297.761 371.797L440.838 48.3174H495.733V0H433.637L462.202 0.0269028Z" fill="white"/></svg>';
        
        return 'data:image/svg+xml;utf8,' . rawurlencode($svg);
    }
}