<?php
use Elementor\Group_Control_Typography;
use Elementor\Controls_Manager;

class HeadingWidget extends \Elementor\Widget_Base
{
    public function get_style_depends()
    {
        return ['heading-widget']; 
    }

    public function get_script_depends()
    {
        return ['heading-widget']; 
    }

    public function get_name()  
    {
        return 'heading-widget';
    }

    public function get_title()
    {
        return __('heading', 'travel');
    }

    public function get_icon()
    {
        return 'eicon-heading';
    }

    protected function _register_controls() {

       /* =========================
           CONTENT
        ========================= */
        $this->start_controls_section(
            'section_content',
            [
                'label' => __( 'Content', 'travel' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Prvi dio teksta
        $this->add_control(
            'heading_text_first',
            [
                'label'       => __( 'First Text', 'travel' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Main text', 'travel' ),
                'label_block' => true,
            ]
        );

        // Drugi dio teksta (koji ide u span)
        $this->add_control(
            'heading_text_second',
            [
                'label'       => __( 'Second Text (Span)', 'travel' ),
                'type'        => Controls_Manager::TEXT,
                'default'     => __( 'Highlighted text', 'travel' ),
                'label_block' => true,
            ]
        );

        // HTML tag
        $this->add_control(
            'heading_tag',
            [
                'label'   => __( 'HTML Tag', 'travel' ),
                'type'    => Controls_Manager::SELECT,
                'default' => 'h3',
                'options' => [
                    'h1'=>'H1','h2'=>'H2','h3'=>'H3','h4'=>'H4','h5'=>'H5','h6'=>'H6','div'=>'DIV','p'=>'P','span'=>'SPAN'
                ],
            ]
        );

        $this->end_controls_section();


        /* =========================
           STYLE
        ========================= */
        $this->start_controls_section(
            'section_style_heading',
            [
                'label' => __( 'Heading', 'travel' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        // Tipografija za cijeli naslov
        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'heading_typography',
                'label'    => __( 'Typography', 'travel' ),
                'selector' => '{{WRAPPER}} .heading-widget__title',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'heading_typography_2',
                'label'    => __( 'Typography 2', 'travel' ),
                'selector' => '{{WRAPPER}} .heading-widget__title-2',
            ]
        );

        $this->add_control(
            'heading_underline_offset',
            [
                'label' => __( 'Underline Offset', 'travel' ),
                'type'  => Controls_Manager::SLIDER,
                'size_units' => [ 'px', 'em', 'rem' ],
                'range' => [
                    'px' => [ 'min' => 0,  'max' => 50 ],
                    'em' => [ 'min' => 0,  'max' => 3, 'step' => 0.1 ],
                    'rem'=> [ 'min' => 0,  'max' => 3, 'step' => 0.1 ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 4,
                ],
                'selectors' => [
                    '{{WRAPPER}} .heading-widget__title-2' =>
                        'text-underline-offset: {{SIZE}}{{UNIT}};',
                ],
            ]
        );


        // Boja glavnog teksta
        $this->add_control(
            'heading_color',
            [
                'label'     => __( 'Text Color', 'travel' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .heading-widget__title' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Boja span teksta
        $this->add_control(
            'heading_span_color',
            [
                'label'     => __( 'Span Text Color', 'travel' ),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .heading-widget__title span' => 'color: {{VALUE}};',
                ],
            ]
        );

        // Margine
        $this->add_responsive_control(
            'heading_margin',
            [
                'label'      => __( 'Margin', 'travel' ),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', 'rem', '%' ],
                'selectors'  => [
                    '{{WRAPPER}} .heading-widget__title' =>
                        'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' .
                        'margin-block-start: {{TOP}}{{UNIT}}; margin-block-end: {{BOTTOM}}{{UNIT}};' .
                        'margin-inline-start: {{LEFT}}{{UNIT}}; margin-inline-end: {{RIGHT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }


    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $tag   = $settings['heading_tag'] ?: 'h3';
        $first = $settings['heading_text_first'];
        $second= $settings['heading_text_second'];

        echo sprintf(
            '<%1$s class="heading-widget__title">%2$s <span class="heading-widget__title-2">%3$s</span></%1$s>',
            esc_attr($tag),
            esc_html($first),
            esc_html($second)
        );
        
    }
}
