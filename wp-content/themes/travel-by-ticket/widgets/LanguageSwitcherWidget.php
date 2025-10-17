<?php
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

class LanguageSwitcherWidget extends \Elementor\Widget_Base
{
    public function get_style_depends()
    {
        return ['language-switcher-widget']; 
    }

    public function get_script_depends()
    {
        return ['language-switcher-widget']; 
    }

    public function get_name()  
    {
        return 'language-switcher-widget';
    }

    public function get_title()
    {
        return __('Language switcher', 'travel');
    }

    public function get_icon()
    {
        return 'eicon-globe';
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
                'label' => __('Content', 'travel'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_flags',
            [
                'label' => __('Show Flags', 'travel'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'travel'),
                'label_off' => __('No', 'travel'),
                'return_value' => 'yes',
                'default' => 'no',
            ]
        );

        $this->add_control(
            'show_names',
            [
                'label' => __('Show Language Names', 'travel'),
                'type' => Controls_Manager::SWITCHER,
                'label_on' => __('Yes', 'travel'),
                'label_off' => __('No', 'travel'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'dropdown_icon',
            [
                'label' => __('Dropdown Icon', 'travel'),
                'type' => Controls_Manager::ICONS,
                'default' => [
                    'value' => 'fas fa-chevron-down',
                    'library' => 'fa-solid',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Button
        $this->start_controls_section(
            'style_button_section',
            [
                'label' => __('Button', 'travel'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'button_typography',
                'selector' => '{{WRAPPER}} .language-switcher-button',
            ]
        );

        $this->add_control(
            'button_text_color',
            [
                'label' => __('Text Color', 'travel'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .language-switcher-button' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'button_bg_color',
            [
                'label' => __('Background Color', 'travel'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .language-switcher-button' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_padding',
            [
                'label' => __('Padding', 'travel'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .language-switcher-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .language-switcher-button',
            ]
        );

        $this->add_control(
            'button_border_radius',
            [
                'label' => __('Border Radius', 'travel'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .language-switcher-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Dropdown
        $this->start_controls_section(
            'style_dropdown_section',
            [
                'label' => __('Dropdown', 'travel'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'dropdown_bg_color',
            [
                'label' => __('Background Color', 'travel'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .language-dropdown' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'dropdown_border',
                'selector' => '{{WRAPPER}} .language-dropdown',
            ]
        );

        $this->add_control(
            'dropdown_border_radius',
            [
                'label' => __('Border Radius', 'travel'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .language-dropdown' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'dropdown_box_shadow',
                'selector' => '{{WRAPPER}} .language-dropdown',
            ]
        );

        $this->add_responsive_control(
            'dropdown_padding',
            [
                'label' => __('Padding', 'travel'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .language-dropdown' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Style Section - Dropdown Items
        $this->start_controls_section(
            'style_items_section',
            [
                'label' => __('Dropdown Items', 'travel'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'item_typography',
                'selector' => '{{WRAPPER}} .language-item',
            ]
        );

        $this->add_control(
            'item_text_color',
            [
                'label' => __('Text Color', 'travel'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .language-item' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'item_hover_color',
            [
                'label' => __('Hover Color', 'travel'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .language-item:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'item_hover_bg_color',
            [
                'label' => __('Hover Background', 'travel'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .language-item:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'item_padding',
            [
                'label' => __('Padding', 'travel'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .language-item' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        // Check if Polylang is active
        if (!function_exists('pll_the_languages')) {
            echo '<p>' . __('Polylang plugin is not active.', 'travel') . '</p>';
            return;
        }

        $settings   = $this->get_settings_for_display();
        $show_flags = $settings['show_flags'] === 'yes';
        $show_names = $settings['show_names'] === 'yes';
        
        // Get all languages
        $languages = pll_the_languages([
            'raw'  => 1,
            'echo' => 0
        ]);

        if (empty($languages)) {
            return;
        }

        // Helper: map locale/slug -> label (Eng/Mne)
        $label_for = function($locale = '', $slug = '') {
            $locale = $locale ?: '';
            $slug   = strtolower($slug ?: '');
            if ($locale === 'en_US' || $slug === 'en') {
                return 'Eng';
            }
            // sve ostalo tretiramo kao Mne (npr. bs_BA)
            return 'Mne';
        };

        // Current language
        $current_lang = null;
        foreach ($languages as $lang) {
            if (!empty($lang['current_lang'])) {
                $current_lang = $lang;
                break;
            }
        }
        if (!$current_lang) {
            // fallback: prvi element
            $current_lang = reset($languages);
        }

        $current_label = $label_for($current_lang['locale'] ?? '', $current_lang['slug'] ?? '');

        ?>
        <div class="language-switcher-wrapper">
            <button class="language-switcher-button"
                    type="button"
                    aria-haspopup="listbox"
                    aria-expanded="false"
                    aria-controls="lang-dd-<?php echo esc_attr($this->get_id()); ?>">

                <?php if ($show_flags && !empty($current_lang['flag'])): ?>
                    <img src="<?php echo esc_url($current_lang['flag']); ?>" alt="<?php echo esc_attr($current_lang['name'] ?? $current_label); ?>" class="lang-flag">
                <?php endif; ?>
                
                <?php if ($show_names): ?>
                    <span class="lang-name"><?php echo esc_html($current_label); ?></span>
                <?php endif; ?>
                
                <?php \Elementor\Icons_Manager::render_icon($settings['dropdown_icon'], ['aria-hidden' => 'true', 'class' => 'dropdown-icon']); ?>
            </button>
            
            <div class="language-dropdown"
                 id="lang-dd-<?php echo esc_attr($this->get_id()); ?>"
                 role="listbox">
                <?php foreach ($languages as $lang): ?>
                    <?php if (empty($lang['current_lang'])): ?>
                        <?php
                            $item_label = $label_for($lang['locale'] ?? '', $lang['slug'] ?? '');
                        ?>
                        <a href="<?php echo esc_url($lang['url']); ?>" class="language-item" role="option" hreflang="<?php echo esc_attr($lang['slug']); ?>">
                            <?php if ($show_flags && !empty($lang['flag'])): ?>
                                <img src="<?php echo esc_url($lang['flag']); ?>" alt="<?php echo esc_attr($lang['name'] ?? $item_label); ?>" class="lang-flag">
                            <?php endif; ?>
                            
                            <?php if ($show_names): ?>
                                <span class="lang-name"><?php echo esc_html($item_label); ?></span>
                            <?php endif; ?>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <?php
    }
}
