'use strict';

function initTabWidget() {
    const tabContainers = document.querySelectorAll('.tab-wrapper');
    
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
        
        // Get both tab-info elements
        const tabInfoElements = container.querySelectorAll('.tab-info');
        if (tabInfoElements.length < 2) return;
        
        let currentIndex = 0; // 0 or 1 - which tab-info is currently active
        let isAnimating = false;
        let activeTabIndex = 0; // Track which tab content is currently shown
        let pendingTabIndex = null; // Track if there's a pending tab change
        
        // Function to update tab content with crossfade effect
        function updateTabContent(index) {
            // Check if current item exists
            if (!items[index]) {
                return;
            }

            // If same tab, do nothing
            if (index === activeTabIndex && !isAnimating) {
                return;
            }

            // If animating, queue the next tab
            if (isAnimating) {
                pendingTabIndex = index;
                return;
            }

            isAnimating = true;
            activeTabIndex = index;
            const currentItem = items[index];
            
            // Determine which element is active and which is hidden
            const activeElement = tabInfoElements[currentIndex];
            const hiddenElement = tabInfoElements[currentIndex === 0 ? 1 : 0];
            
            // Update hidden element with new content
            const image = hiddenElement.querySelector('.tab-image');
            if (image) {
                image.src = currentItem.image;
                image.alt = currentItem.title;
            }

            const heading = hiddenElement.querySelector('.tab-heading');
            if (heading) {
                heading.textContent = currentItem.title;
            }

            const text = hiddenElement.querySelector('.text');
            if (text) {
                text.innerHTML = currentItem.text;
            }

            const cta = hiddenElement.querySelector('.cta');
            if (cta) {
                cta.href = currentItem.link;
                cta.textContent = currentItem.cta_text;
            }
            
            // Small delay to ensure content is loaded before transition
            requestAnimationFrame(() => {
                // Swap active states - crossfade effect
                activeElement.classList.remove('active');
                hiddenElement.classList.add('active');
                
                // Switch current index
                currentIndex = currentIndex === 0 ? 1 : 0;
            });
            
            // Reset animation lock after transition
            setTimeout(() => {
                isAnimating = false;
                
                // If there's a pending tab change, process it
                if (pendingTabIndex !== null && pendingTabIndex !== activeTabIndex) {
                    const nextIndex = pendingTabIndex;
                    pendingTabIndex = null;
                    updateTabContent(nextIndex);
                } else {
                    pendingTabIndex = null;
                }
            }, 600); // Match CSS transition duration
        }
        
        // Handle desktop tab headings click
        const tabHeadings = tabItemsContainer.querySelectorAll('.tab-item__heading');
        
        tabHeadings.forEach((heading, index) => {
            heading.addEventListener('click', function() {
                // Update UI immediately
                tabHeadings.forEach(h => h.classList.remove('is-active'));
                this.classList.add('is-active');
                
                // Update icons immediately
                if (tabIconsContainer) {
                    const allIcons = tabIconsContainer.querySelectorAll('.tab-icon');
                    allIcons.forEach(icon => icon.classList.remove('is-active'));
                    if (allIcons[index]) {
                        allIcons[index].classList.add('is-active');
                    }
                }
                
                // Update content (may be queued if animating)
                updateTabContent(index);
            });
        });
        
        // Handle mobile tab icons click
        // if (tabIconsContainer) {
        //     const tabIcons = tabIconsContainer.querySelectorAll('.tab-icon');
            
        //     tabIcons.forEach((icon, index) => {
        //         icon.addEventListener('click', function() {
        //             // Update UI immediately
        //             tabIcons.forEach(i => i.classList.remove('is-active'));
        //             this.classList.add('is-active');
                    
        //             // Update headings immediately
        //             tabHeadings.forEach(h => h.classList.remove('is-active'));
        //             if (tabHeadings[index]) {
        //                 tabHeadings[index].classList.add('is-active');
        //             }
                    
        //             // Update content (may be queued if animating)
        //             updateTabContent(index);
        //         });
        //     });
        // }
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

const swiper = new Swiper('.tabSwiperMobile',{
    slidesPerView: 1,
    loop: true,
    speed: 500,
    simulateTouch: true,
    allowTouchMove: true,
    spaceBetween: 24,
    pagination: {
        el: '.tabPagination',
        clickable: true,
        type: 'custom', 
        renderCustom: function (swiper, current, total) {
            let bullets = '';
            for (let i = 1; i <= total; i++) {
                bullets += `
                    <span class="tab-icon ${i === current ? 'active' : ''}" data-index="${i - 1}">
                        <svg width="23" height="19" viewBox="0 0 23 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path opacity="${i === current ? '1' : '0.22'}" d="M21.4143 0.00173743L17.5979 0C17.3342 1.12041 16.3474 1.95246 15.1683 1.95246C13.9892 1.95246 13.0024 1.12041 12.7386 0H11.3282C10.6714 0 10.0776 0.39605 9.81218 1.00923L3.04897 16.6654L0 16.6689V19H5.39695C5.66068 17.8796 6.64751 17.0475 7.8266 17.0475C9.0057 17.0475 9.99253 17.8796 10.2563 19H12.1261C12.7829 19 13.3767 18.604 13.6421 17.9908L20.4053 2.33809H23V0H21.4143V0.00173743Z" fill="#480E66"/>
                        </svg>
                    </span>`;
            }
            return bullets;
        }
    },
    lazy: {
      enabled: true,
      loadPrevNext: true,
      loadPrevNextAmount: 1,
      loadOnTransitionStart: true,
    },  
});

document.querySelector('.tabPagination').addEventListener('click', function(e) {
    const bullet = e.target.closest('.tab-icon');
    if (bullet) {
        const index = parseInt(bullet.getAttribute('data-index'));
        swiper.slideToLoop(index);
    }
});