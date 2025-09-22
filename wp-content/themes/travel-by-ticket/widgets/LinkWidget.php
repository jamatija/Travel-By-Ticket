<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Text_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;

class LinkWidget extends \Elementor\Widget_Base
{
    public function get_style_depends()
    {
        return ['link-widget']; // tvoj CSS handle
    }

    public function get_name()
    {
        return 'link-widget';
    }

    public function get_title()
    {
        return __('Link', 'travel');
    }

    public function get_icon()
    {
        return 'eicon-link';
    }

    protected function _register_controls()
    {
        // ====== Content tab ======
        $this->start_controls_section(
            'section_content',
            [
                'label' => __('Content', 'travel'),
            ]
        );

        $this->add_control(
            'text',
            [
                'label'       => __('Text', 'travel'),
                'type'        => Controls_Manager::TEXT,
                'default'     => __('Learn more', 'travel'),
                'placeholder' => __('Enter link text', 'travel'),
                'label_block' => true,
            ]
        );

        $this->add_control(
            'link',
            [
                'label'         => __('Link', 'travel'),
                'type'          => Controls_Manager::URL,
                'placeholder'   => __('https://example.com', 'travel'),
                'show_external' => true, // prikazuje "Open in new window" i "nofollow"
                'default'       => [
                    'url'         => '',
                    'is_external' => false,
                    'nofollow'    => false,
                    'custom_attributes' => '',
                ],
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label'     => __('Alignment', 'travel'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => __('Left', 'travel'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'travel'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => __('Right', 'travel'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'  => 'left',
                'selectors' => [
                    '{{WRAPPER}} .tw-link-wrap' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // ====== Style tab ======
        $this->start_controls_section(
            'section_style',
            [
                'label' => __('Link Style', 'travel'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'typography',
                'selector' => '{{WRAPPER}} .tw-link',
            ]
        );


        $this->start_controls_tabs('tabs_colors');

        // Normal
        $this->start_controls_tab(
            'tab_normal',
            ['label' => __('Normal', 'travel')]
        );

        $this->add_control(
            'color',
            [
                'label'     => __('Text Color', 'travel'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tw-link' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'     => 'border',
                'selector' => '{{WRAPPER}} .tw-link',
            ]
        );

        $this->add_responsive_control(
            'padding',
            [
                'label'      => __('Padding', 'travel'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .tw-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // Hover
        $this->start_controls_tab(
            'tab_hover',
            ['label' => __('Hover', 'travel')]
        );

        $this->add_control(
            'hover_color',
            [
                'label'     => __('Text Color (Hover)', 'travel'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .tw-link:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'hover_underline',
            [
                'label'        => __('Underline on Hover', 'travel'),
                'type'         => Controls_Manager::SWITCHER,
                'return_value' => 'yes',
                'default'      => '',
                'selectors'    => [
                    '{{WRAPPER}} .tw-link:hover' => 'text-decoration: {{VALUE}};',
                ],
                'selectors_dictionary' => [
                    'yes' => 'underline',
                    ''    => 'none',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        // Background (optional, ako želiš dugme-stil linka)
        $this->start_controls_section(
            'section_bg',
            [
                'label' => __('Background (optional)', 'travel'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'background',
                'selector' => '{{WRAPPER}} .tw-link',
                'types'    => ['classic', 'gradient'],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();

        $text = !empty($s['text']) ? $s['text'] : '';

        $url        = !empty($s['link']['url']) ? $s['link']['url'] : '';
        $is_external = !empty($s['link']['is_external']);
        $nofollow    = !empty($s['link']['nofollow']);
        $custom_attr = !empty($s['link']['custom_attributes']) ? $s['link']['custom_attributes'] : '';

        $this->add_render_attribute('link', 'class', 'tw-link');

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

        <a style="display: inline-block;" <?php echo $this->get_render_attribute_string('link'); ?>>
            <?php echo esc_html($text); ?>
        </a>

        <?php
    }
}
