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
        320:  { slidesPerView: slidesPerViewMobile, spaceBetween: 24, slidesOffsetAfter: 24 },
        768:  { slidesPerView: slidesPerViewTablet, spaceBetween: 20 },
        1025: { slidesPerView: slidesPerViewDesktop, spaceBetween: 32 },
      },
    };

    const swiper = new Swiper(root, swiperConfig);

    swiper.on('slideChange', () => {
      wrapper.classList.add('has-seen-prev');
    });

    if (isLayout2) {
      const allSlides = Array.from(wrapper.querySelectorAll('.swiper-slide'));
      const filterBtns = wrapper.querySelectorAll('.filter-btn');


    function toggleButtons(category) {

      const travelBtn = wrapper.querySelector('.dynamic-button-travel');
      const blogBtn = wrapper.querySelector('.dynamic-button-blog');
      
      const travelBtnMobile = document.querySelector('.dynamic-button-travel-mobile');
      const blogBtnMobile = document.querySelector('.dynamic-button-blog-mobile');

      const showTravel = category === 'travel-news';

      [travelBtn, travelBtnMobile].forEach(btn => {
        if (!btn) return;
        btn.classList.toggle('is-hidden', !showTravel);
      });

      [blogBtn, blogBtnMobile].forEach(btn => {
        if (!btn) return;
        btn.classList.toggle('is-hidden', showTravel);
      });

       if (category === 'travel-news') {
        document.body.classList.remove('layout_2__blog');
      } else {
        document.body.classList.add('layout_2__blog');
      }
    }

      function filterSlides(category) {
        const matchingSlides = allSlides.filter(slide => slide.dataset.category === category);
        const slidesToShow = matchingSlides.length > 0 ? matchingSlides : allSlides;

        swiper.removeAllSlides();
        slidesToShow.forEach(slide => {
          const clonedSlide = slide.cloneNode(true);
          clonedSlide.style.display = 'block';
          swiper.appendSlide(clonedSlide);
        });

        swiper.update();
        swiper.slideTo(0, 50);

        toggleButtons(category);
      }

      filterBtns.forEach((btn) => {
        btn.addEventListener('click', function () {
          filterBtns.forEach((b) => b.classList.remove('active'));
          this.classList.add('active');
          filterSlides(this.dataset.filter);
        });
      });

      // Init state
      const activeBtn = wrapper.querySelector('.filter-btn.active');
      const initialCategory = activeBtn ? activeBtn.dataset.filter : 'travel-news';
      toggleButtons(initialCategory);
      filterSlides(initialCategory);
    }
  });

  // Global
  document.addEventListener('click', function (e) {
    const nextBtn = e.target.closest('.carousel-button-next');
    if (!nextBtn) return;
    const wrapper = nextBtn.closest('.carousel-wrapper');
    if (wrapper) wrapper.classList.add('has-seen-prev');
  });
});
