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

        if ( ! empty( $settings['image']['url'] ) ) {
            $image_url = $settings['image']['url'];
        } else

        $mask_url = $this->get_default_mask_svg();

        // Build aspect ratio
        $aspect_ratio = '622 / 434';

        // Build inline styles
        $inline_styles = '--img:url(\'' . esc_url( $image_url ) . '\');';

        ?>
        <div class="shaped" style="--img:url('<?php echo $image_url; ?>')"></div>
        <?php
    }

    /**
     * Get default SVG mask as data URI or return path to SVG file
     */
    protected function get_default_mask_svg() {
        // Option 1: Return data URI with inline SVG
        $svg = '<svg viewBox="0 0 622 434" xmlns="http://www.w3.org/2000/svg">
                <path d="M584.938 0.0297362L447.443 0C441.271 25.5731 418.193 44.6043 390.643 44.6043C363.092 44.6043 340.014 25.6029 333.842 0H264.919C249.564 0 235.669 9.03981 229.467 23.0456L71.2911 380.653L0 380.742V434H162.129C168.301 408.427 191.379 389.396 218.93 389.396C246.48 389.396 269.558 408.397 275.73 434H367.725C383.081 434 396.975 424.96 403.177 410.954L561.324 53.4062H622V0H553.364L584.938 0.0297362Z"
                        fill="white"/>
                </svg>
                ';
        
        return 'data:image/svg+xml;base64,' . base64_encode( $svg );
        
    }

}