(function($) {
    'use strict';

    $(window).on('elementor/frontend/init', function() {
        elementorFrontend.hooks.addAction('frontend/element_ready/language-switcher-widget.default', function($scope) {
            const $wrapper = $scope.find('.language-switcher-wrapper');
            const $button = $wrapper.find('.language-switcher-button');
            const $dropdown = $wrapper.find('.language-dropdown');

            $button.on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                $wrapper.toggleClass('active');
                $dropdown.stop(true, true).slideToggle(200);
            });

            $wrapper.on('mouseenter', function() {
                if (window.matchMedia('(hover: hover)').matches) {
                    $wrapper.addClass('active');
                    $dropdown.stop(true, true).slideDown(200);
                }
            }).on('mouseleave', function() {
                if (window.matchMedia('(hover: hover)').matches) {
                    $wrapper.removeClass('active');
                    $dropdown.stop(true, true).slideUp(200);
                }
            });

            $(document).on('click.languageSwitcher', function(e) {
                if (!$wrapper.is(e.target) && $wrapper.has(e.target).length === 0) {
                    $wrapper.removeClass('active');
                    $dropdown.stop(true, true).slideUp(200);
                }
            });

            $(document).on('keydown.languageSwitcher', function(e) {
                if (e.key === 'Escape') {
                    $wrapper.removeClass('active');
                    $dropdown.stop(true, true).slideUp(200);
                }
            });
        });
    });

})(jQuery);
