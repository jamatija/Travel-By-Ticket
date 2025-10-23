<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Css_Filter;

class LogoWidget extends \Elementor\Widget_Base
{
    public function get_style_depends()
    {
        return ['logo-hover-widget']; 
    }

    public function get_name()  
    {
        return 'logo-hover-widget';
    }

    public function get_title()
    {
        return __('Logo Hover', 'travel');
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
        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => __('Logo Images', 'travel'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'light_logo',
            [
                'label' => __('Light Logo (Default)', 'travel'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'dark_logo',
            [
                'label' => __('Dark Logo (Hover)', 'travel'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
            ]
        );

        $this->add_control(
            'logo_link',
            [
                'label' => __('Link', 'travel'),
                'type' => Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'travel'),
                'default' => [
                    'url' => home_url('/'),
                ],
            ]
        );

        $this->add_control(
            'logo_alt',
            [
                'label' => __('Alt Text', 'travel'),
                'type' => Controls_Manager::TEXT,
                'default' => __('Logo', 'travel'),
            ]
        );

        $this->end_controls_section();

        // Style Section - Size
        $this->start_controls_section(
            'style_size_section',
            [
                'label' => __('Size', 'travel'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'logo_width',
            [
                'label' => __('Width', 'travel'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%', 'vw'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 500,
                    ],
                    '%' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 150,
                ],
                'selectors' => [
                    '{{WRAPPER}} .logo-hover-wrapper' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'logo_max_width',
            [
                'label' => __('Max Width', 'travel'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px', '%'],
                'range' => [
                    'px' => [
                        'min' => 50,
                        'max' => 1000,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .logo-hover-wrapper' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'logo_align',
            [
                'label' => __('Alignment', 'travel'),
                'type' => Controls_Manager::CHOOSE,
                'options' => [
                    'left' => [
                        'title' => __('Left', 'travel'),
                        'icon' => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => __('Center', 'travel'),
                        'icon' => 'eicon-text-align-center',
                    ],
                    'right' => [
                        'title' => __('Right', 'travel'),
                        'icon' => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'left',
                'selectors' => [
                    '{{WRAPPER}} .logo-hover-container' => 'text-align: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Effects
        $this->start_controls_section(
            'style_effects_section',
            [
                'label' => __('Effects', 'travel'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'transition_duration',
            [
                'label' => __('Transition Duration (ms)', 'travel'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 2000,
                        'step' => 50,
                    ],
                ],
                'default' => [
                    'size' => 300,
                ],
                'selectors' => [
                    '{{WRAPPER}} .logo-image' => 'transition-duration: {{SIZE}}ms;',
                ],
            ]
        );

        $this->add_control(
            'hover_opacity',
            [
                'label' => __('Hover Opacity', 'travel'),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'size' => 1,
                ],
                'selectors' => [
                    '{{WRAPPER}} .logo-hover-wrapper:hover .logo-dark' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'logo_filters',
                'selector' => '{{WRAPPER}} .logo-image',
            ]
        );

        $this->add_group_control(
            Group_Control_Css_Filter::get_type(),
            [
                'name' => 'logo_hover_filters',
                'label' => __('Hover Filters', 'travel'),
                'selector' => '{{WRAPPER}} .logo-hover-wrapper:hover .logo-image',
            ]
        );

        $this->end_controls_section();

        // Style Section - Border & Shadow
        $this->start_controls_section(
            'style_border_section',
            [
                'label' => __('Border & Shadow', 'travel'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'logo_border',
                'selector' => '{{WRAPPER}} .logo-hover-wrapper',
            ]
        );

        $this->add_control(
            'logo_border_radius',
            [
                'label' => __('Border Radius', 'travel'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .logo-hover-wrapper' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .logo-image' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'logo_box_shadow',
                'selector' => '{{WRAPPER}} .logo-hover-wrapper',
            ]
        );

        $this->add_responsive_control(
            'logo_padding',
            [
                'label' => __('Padding', 'travel'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .logo-hover-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        $light_logo_url = $settings['light_logo']['url'];
        $dark_logo_url = $settings['dark_logo']['url'];
        $logo_alt = $settings['logo_alt'];
        
        $this->add_link_attributes('logo_link', $settings['logo_link']);
        
        ?>
        <div class="logo-hover-container">
            <?php if (!empty($settings['logo_link']['url'])): ?>
                <a <?php echo $this->get_render_attribute_string('logo_link'); ?> class="logo-hover-wrapper">
            <?php else: ?>
                <div class="logo-hover-wrapper">
            <?php endif; ?>
            
                <img src="<?php echo esc_url($light_logo_url); ?>" 
                     alt="<?php echo esc_attr($logo_alt); ?>" 
                     class="logo-image logo-light">
                
                <img src="<?php echo esc_url($dark_logo_url); ?>" 
                     alt="<?php echo esc_attr($logo_alt); ?>" 
                     class="logo-image logo-dark">
            
            <?php if (!empty($settings['logo_link']['url'])): ?>
                </a>
            <?php else: ?>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }

    protected function content_template() {
        ?>
        <#
        var lightLogoUrl = settings.light_logo.url,
            darkLogoUrl = settings.dark_logo.url,
            logoAlt = settings.logo_alt;
        #>
        <div class="logo-hover-container">
            <# if (settings.logo_link.url) { #>
                <a href="{{ settings.logo_link.url }}" class="logo-hover-wrapper">
            <# } else { #>
                <div class="logo-hover-wrapper">
            <# } #>
            
                <img src="{{ lightLogoUrl }}" alt="{{ logoAlt }}" class="logo-image logo-light">
                <img src="{{ darkLogoUrl }}" alt="{{ logoAlt }}" class="logo-image logo-dark">
            
            <# if (settings.logo_link.url) { #>
                </a>
            <# } else { #>
                </div>
            <# } #>
        </div>
        <?php
    }
}