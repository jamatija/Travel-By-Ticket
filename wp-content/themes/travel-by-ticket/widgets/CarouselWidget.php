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

        <!-- Slider main container -->
        <div class="swiper carouselSwiper">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
                <div class="swiper-slide">Slide 1</div>
                <div class="swiper-slide">Slide 2</div>
                <div class="swiper-slide">Slide 3</div>
                <div class="swiper-slide">Slide 4</div>
                <div class="swiper-slide">Slide 5</div>
                ...
            </div>


            <!-- navigation buttons -->
            <div class="carousel-button-prev"></div>
            <div class="carousel-button-next"></div>

        </div>

        <?php

    }
}
