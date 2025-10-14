<?php
use Elementor\Group_Control_Typography;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;

class TabWidget extends \Elementor\Widget_Base
{
    public function get_style_depends()
    {
        return ['tab-widget']; 
    }

    public function get_script_depends()
    {
        return ['tab-widget']; 
    }

    public function get_name()  
    {
        return 'tab-widget';
    }

    public function get_title()
    {
        return __('Tab content', 'travel');
    }

    public function get_icon()
    {
        return 'eicon-tabs';
    }

protected function register_controls() {

        $repeater = new Repeater();

        $repeater->add_control(
            'item_title',
            [
                'label'       => __( 'Title', 'travel' ),
                'type'        => Controls_Manager::TEXT,
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'item_text',
            [
                'label'       => __( 'Text', 'travel' ),
                'type'        => Controls_Manager::TEXTAREA,
                'rows'        => 3,
            ]
        );

        $repeater->add_control(
            'item_image',
            [
                'label'   => __( 'Image', 'travel' ),
                'type'    => Controls_Manager::MEDIA,
                'default' => [
                    'url' => Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $repeater->add_control(
            'item_cta_text',
            [
                'label'       => __( 'Link text', 'travel' ),
                'type'        => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'static_link',
            [
                'label'   => __( 'Link', 'travel' ),
                'type'    => Controls_Manager::URL,
                'default' => [
                    'url' => '#',
                    'is_external' => false,
                    'nofollow' => false,
                ],
                'label_block' => true,
            ]
        );


        $this->start_controls_section(
            'section_list',
            [
                'label' => __( 'Items', 'travel' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'items',
            [
                'label'       => __( 'Repeater List', 'travel' ),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => '{{{ item_title }}}',
                'default'     => [
                    [
                        'item_title'   => __( 'Item 1', 'travel' ),
                        'item_cta_text'=> __( 'Read more', 'travel' ),
                    ],
                ],
            ]
        );

        $this->end_controls_section();
    }


    protected function render()
    {
        $settings = $this->get_settings_for_display();

        // Prepare data
        $items = array_map( function( $item ) {
            return [
                'title'    => isset( $item['item_title'] ) ? wp_kses_post( $item['item_title'] ) : '',
                'text'     => isset( $item['item_text'] ) ? wp_kses_post( $item['item_text'] ) : '',
                'cta_text' => isset( $item['item_cta_text'] ) ? wp_kses_post( $item['item_cta_text'] ) : '',
                'link'     => isset( $item['static_link']['url'] ) ? esc_url_raw( $item['static_link']['url'] ) : '',
                'image'    => isset( $item['item_image']['url'] ) ? esc_url_raw( $item['item_image']['url'] ) : '',
            ];
        }, $settings['items'] );

        $json = wp_json_encode( $items, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES );

        //Falback
        if ( false === $json ) {
            $json = '[]';
        }

        $first = $items[0];
    ?>

        <div class="tab-container">
            <div class="tab-info">
                <img class="tab-image" src="<?php echo esc_url( $first['image'] ); ?>" alt="<?php echo esc_attr( $first['title'] ); ?>">
                <div class="tab-text-box">
                    <span class="tab-heading"><?php echo esc_html( $first['title'] ); ?></span>
                    <p class="text"><?php echo wp_kses_post( $first['text'] ); ?></p>
                    <a class="cta" href="<?php echo esc_url( $first['link'] ); ?>">
                        <?php echo esc_html( $first['cta_text'] ); ?>
                    </a>
                </div>
            </div>
            <div class="tab-items" data-count="<?php echo esc_attr( count( $items ) ); ?>" data-items="<?php echo esc_attr( $json ); ?>">
                <?php foreach ( $settings['items'] as $index => $item ) :
                ?>
                    <h3 class="tab-item__heading <?php echo $index === 0 ? 'is-active' : ''; ?>">
                        <span>
                            <svg width="12" height="20" viewBox="0 0 12 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M10 20L0 10L10 0L11.775 1.775L3.55 10L11.775 18.225L10 20Z" fill="#F4B821"/>
                            </svg>
                        </span> 
                        <?php echo esc_html( $item['item_title'] ); ?>
                    </h3>
                <?php endforeach ?>
            </div>
            <div class="tab-icons" data-count="<?php echo esc_attr( count( $items ) ); ?>" data-items="<?php echo esc_attr( $json ); ?>">
                <?php foreach( $items as $index => $item ): ?>
                    <span class="tab-icon <?php echo $index === 0 ? 'is-active' : ''; ?>" data-index="<?php echo esc_attr( $index ); ?>">
                        <svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.22" d="M21.4143 0.00173743L17.5979 0C17.3342 1.12041 16.3474 1.95246 15.1683 1.95246C13.9892 1.95246 13.0024 1.12041 12.7386 0H11.3282C10.6714 0 10.0776 0.39605 9.81218 1.00923L3.04897 16.6654L0 16.6689V19H5.39695C5.66068 17.8796 6.64751 17.0475 7.8266 17.0475C9.0057 17.0475 9.99253 17.8796 10.2563 19H12.1261C12.7829 19 13.3767 18.604 13.6421 17.9908L20.4053 2.33809H23V0H21.4143V0.00173743Z" fill="#480E66"/>
                        </svg>
                    </span>
                <?php endforeach ?>
            </div>
        </div>    

    <?php
    }
}