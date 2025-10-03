document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.carouselSwiper').forEach((root) => {
    const wrapper = root.closest('.carousel-wrapper'); 
    const nextBtn = wrapper.querySelector('.carousel-button-next');
    const prevBtn = wrapper.querySelector('.carousel-button-prev'); 
    const isLayout2 = wrapper.classList.contains('layout_2');

    // Layout-specific settings
    let slidesPerViewMobile = 1.21;
    let slidesPerViewTablet = 3;
    let slidesPerViewDesktop = 4;

    if (isLayout2) {
      slidesPerViewMobile = 1.1;
      slidesPerViewTablet = 2.5;
      slidesPerViewDesktop = 3.6;
    }

    const swiperConfig = {
      slidesPerView: slidesPerViewDesktop,
      loop: true,
      speed: 500,
      simulateTouch: true,
      allowTouchMove: true,
      grabCursor: true,
      preventClicks: false,
      preventClicksPropagation: false,
      lazy: {
        enabled: true,
        loadPrevNext: true,
        loadPrevNextAmount: 1,
        loadOnTransitionStart: true,
      },
      navigation: {
        nextEl: nextBtn,
        prevEl: prevBtn,
      },
      breakpoints: {
        320:  { slidesPerView: slidesPerViewMobile, spaceBetween: 24, slidesOffsetBefore: 24, slidesOffsetAfter: 24 },
        768:  { slidesPerView: slidesPerViewTablet, spaceBetween: 20 },
        1025: { slidesPerView: slidesPerViewDesktop, spaceBetween: 32 },
      },
    };

    const swiper = new Swiper(root, swiperConfig);

    swiper.on('slideChange', () => {
      wrapper.classList.add('has-seen-prev');
    });

    // === Filtering layout_2 ===
    if (isLayout2) {
      // Save all slide 
      const allSlides = Array.from(wrapper.querySelectorAll('.swiper-slide'));
      
      function filterSlides(category) {
        // Find slides by category
        const matchingSlides = allSlides.filter(slide => 
          slide.dataset.category === category
        );

        // Show all if no slides
        const slidesToShow = matchingSlides.length > 0 ? matchingSlides : allSlides;

        // Remove all slide
        swiper.removeAllSlides();

        // Add proper slides
        slidesToShow.forEach(slide => {
          const clonedSlide = slide.cloneNode(true);
          clonedSlide.style.display = 'block';
          swiper.appendSlide(clonedSlide);
        });

        // Reset swiper on 1 slide
        swiper.update();
        swiper.slideTo(0, 50); 
      }

      const filterBtns = wrapper.querySelectorAll('.filter-btn');
      filterBtns.forEach((btn) => {
        btn.addEventListener('click', function () {
          filterBtns.forEach((b) => b.classList.remove('active'));
          this.classList.add('active');
          filterSlides(this.dataset.filter);
        });
      });

      // Initialization
      filterSlides('travel-news');
    }
  });

  // Global event listener
  document.addEventListener('click', function (e) {
    const nextBtn = e.target.closest('.carousel-button-next');
    if (!nextBtn) return;
    const wrapper = nextBtn.closest('.carousel-wrapper');
    if (wrapper) wrapper.classList.add('has-seen-prev');
  });
});