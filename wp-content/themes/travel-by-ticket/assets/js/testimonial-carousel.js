document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.testimonialSwiper').forEach((root) => {
    const wrapper = root.closest('.testimonialCarousel'); 
    const nextBtn = wrapper.querySelector('.testimonialCarousel .carousel-button-next');
    const prevBtn = wrapper.querySelector('.testimonialCarousel .carousel-button-prev'); 


    let slidesPerViewMobile = 1;
    let slidesPerViewTablet = 2;
    let slidesPerViewDesktop = 3;

    const swiper = new Swiper(root, {
      slidesPerView: slidesPerViewDesktop,
      loop: true,
      speed: 500,
     
      simulateTouch: true,
      allowTouchMove: true,
      grabCursor: true,
      preventClicks: true,       
      preventClicksPropagation: true,

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
        320:  { slidesPerView: slidesPerViewMobile, spaceBetween: 20 },
        769:  { slidesPerView: slidesPerViewTablet, spaceBetween: 0 },
        1025: { slidesPerView: slidesPerViewDesktop, spaceBetween: 20 },
        1367: { slidesPerView: slidesPerViewDesktop, spaceBetween: 50 },
      },
    });
   swiper.on('slideChange', () => {
      wrapper.classList.add('has-seen-prev');
    });
  });

  document.addEventListener('click', function (e) {
    const nextBtn = e.target.closest('.carousel-button-next');
    if (!nextBtn) return;
    const wrapper = nextBtn.closest('.carousel-wrapper'); 
    if (wrapper) wrapper.classList.add('has-seen-prev');
  });
});
