'use strict';

function initTabWidget() {
    const tabContainers = document.querySelectorAll('.tab-container');
    
    tabContainers.forEach((container) => {
        // Get items data from tab-items container
        const tabItemsContainer = container.querySelector('.tab-items');
        const tabIconsContainer = container.querySelector('.tab-icons');
        
        if (!tabItemsContainer) return;
        
        const itemsData = tabItemsContainer.getAttribute('data-items');
        const items = itemsData ? JSON.parse(itemsData) : null;
        
        // Check if items are valid
        if (!items || !Array.isArray(items)) {
            return;
        }
        
        // Function to update tab content with fade effect
        function updateTabContent(index) {
            // Check if current item exists
            if (!items[index]) {
                return;
            }

            const currentItem = items[index];
            
            // Get all elements to animate
            const image = container.querySelector('.tab-image');
            const heading = container.querySelector('.tab-heading');
            const text = container.querySelector('.text');
            const cta = container.querySelector('.cta');
            
            const elements = [image, heading, text, cta].filter(el => el !== null);
            
            // Fade out
            elements.forEach(el => el.classList.add('fade-out'));
            
            // Wait for fade out, then update content and fade in
            setTimeout(() => {
                // Update image
                if (image) {
                    image.src = currentItem.image;
                    image.alt = currentItem.title;
                }

                // Update heading
                if (heading) {
                    heading.textContent = currentItem.title;
                }

                // Update text
                if (text) {
                    text.innerHTML = currentItem.text;
                }

                // Update link and link text
                if (cta) {
                    cta.href = currentItem.link;
                    cta.textContent = currentItem.cta_text;
                }
                
                // Fade in
                setTimeout(() => {
                    elements.forEach(el => el.classList.remove('fade-out'));
                }, 50);
                
            }, 300); // Match this with CSS transition duration
        }
        
        // Handle desktop tab headings click
        const tabHeadings = tabItemsContainer.querySelectorAll('.tab-item__heading');
        
        tabHeadings.forEach((heading, index) => {
            heading.addEventListener('click', function() {
                // Remove active class from all headings
                tabHeadings.forEach(h => h.classList.remove('is-active'));
                
                // Add active class to clicked heading
                this.classList.add('is-active');
                
                // Remove active class from all icons
                if (tabIconsContainer) {
                    const allIcons = tabIconsContainer.querySelectorAll('.tab-icon');
                    allIcons.forEach(icon => icon.classList.remove('is-active'));
                    
                    // Add active class to corresponding icon
                    if (allIcons[index]) {
                        allIcons[index].classList.add('is-active');
                    }
                }
                
                // Update content with fade effect
                updateTabContent(index);
            });
        });
        
        // Handle mobile tab icons click
        if (tabIconsContainer) {
            const tabIcons = tabIconsContainer.querySelectorAll('.tab-icon');
            
            tabIcons.forEach((icon, index) => {
                icon.addEventListener('click', function() {
                    // Remove active class from all icons
                    tabIcons.forEach(i => i.classList.remove('is-active'));
                    
                    // Add active class to clicked icon
                    this.classList.add('is-active');
                    
                    // Remove active class from all headings
                    tabHeadings.forEach(h => h.classList.remove('is-active'));
                    
                    // Add active class to corresponding heading
                    if (tabHeadings[index]) {
                        tabHeadings[index].classList.add('is-active');
                    }
                    
                    // Update content with fade effect
                    updateTabContent(index);
                });
            });
        }
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