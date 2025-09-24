<?php
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;

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


    }


    protected function render()
    {
        $settings = $this->get_settings_for_display();
        
    }
}
