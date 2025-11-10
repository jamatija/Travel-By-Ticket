<?php
class TravelMapWidget extends \Elementor\Widget_Base {

    public function get_name() {
        return 'bus-stations-map';
    }

    public function get_title() {
        return __('Bus Stations Map', 'travel');
    }

    public function get_icon() {
        return 'eicon-google-maps';
    }

    public function get_categories() {
        return ['general'];
    }

    public function get_style_depends()  { return ['leaflet-lib', 'bus-stations-map']; }
    public function get_script_depends() { return ['leaflet-lib', 'bus-stations-map']; }

    protected function render() {
        $map_id = 'tw-bus-map-' . $this->get_id();
        echo '<div id="'.esc_attr($map_id).'" class="tw-bus-map" style="height:520px;"></div>';
    }
}
