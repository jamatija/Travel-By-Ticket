'use strict';

function initTabWidget() {
    const tabHeadings = document.querySelectorAll('.tab-item__heading');
    
    tabHeadings.forEach((heading) => {
        heading.addEventListener('click', function() {
            const itemsData = this.getAttribute('data-items');
            const items = itemsData ? JSON.parse(itemsData) : null;
            
            // Find the index of the current element
            const parent = this.parentElement;
            const allHeadings = Array.from(parent.querySelectorAll('.tab-item__heading'));
            const index = allHeadings.indexOf(this);

            // Check if items are valid
            if (!items || !Array.isArray(items) || !items[index]) {
                return;
            }

            const currentItem = items[index];

            // Remove active class from all tabs
            allHeadings.forEach(h => h.classList.remove('is-active'));
            
            // Add active class to clicked tab
            this.classList.add('is-active');

            // Find the parent tab-container
            const container = this.closest('.tab-container');
            
            if (!container) return;
            
            // Update image
            const image = container.querySelector('.tab-image');
            if (image) {
                image.src = currentItem.image;
                image.alt = currentItem.title;
            }

            // Update heading
            const heading = container.querySelector('.tab-heading');
            if (heading) {
                heading.textContent = currentItem.title;
            }

            // Update text
            const text = container.querySelector('.text');
            if (text) {
                text.innerHTML = currentItem.text;
            }

            // Update link and link text
            const cta = container.querySelector('.cta');
            if (cta) {
                cta.href = currentItem.link;
                cta.textContent = currentItem.cta_text;
            }
        });
    });
}

// Initialize widget when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initTabWidget);
} else {
    initTabWidget();
}

// Reinitialize after Elementor loads preview
window.addEventListener('elementor/frontend/init', function() {
    if (typeof elementorFrontend !== 'undefined') {
        elementorFrontend.hooks.addAction('frontend/element_ready/tab-widget.default', function() {
            initTabWidget();
        });
    }
});