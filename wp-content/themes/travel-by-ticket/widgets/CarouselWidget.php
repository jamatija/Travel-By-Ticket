<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Background;

class CarouselWidget extends \Elementor\Widget_Base
{
    public function get_style_depends()
    {
        return ['carousel-widget']; 
    }

    public function get_script_depends()
    {
        return ['carousel-widget']; 
    }

    public function get_name()  
    {
        return 'carousel-widget';
    }

    public function get_title()
    {
        return __('carousel', 'travel');
    }

    public function get_icon()
    {
        return 'eicon-carousel';
    }

    protected function _register_controls()
    {
        

    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();?>

<h1>test</h1>
        <?php

    }
}
