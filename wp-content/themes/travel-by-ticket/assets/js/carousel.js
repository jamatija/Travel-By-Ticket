document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.carouselSwiper').forEach((root) => {
    const wrapper = root.closest('.carousel-wrapper'); 
    const nextBtn = wrapper.querySelector('.carousel-button-next');
    const prevBtn = wrapper.querySelector('.carousel-button-prev'); 

    const isLayout2 = wrapper.classList.contains('layout_2');

    //Layout-1 settings
    let slidesPerViewMobile = 1.21;
    let slidesPerViewTablet = 3;
    let slidesPerViewDesktop = 4;

    //Layout-2 settings
    if(isLayout2){
      slidesPerViewMobile = 1.1;
      slidesPerViewTablet = 2.5;
      slidesPerViewDesktop = 3.6;
    }


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
        320:  { slidesPerView: slidesPerViewMobile, spaceBetween: 22, slidesOffsetBefore: 20,  },
        768:  { slidesPerView: slidesPerViewTablet, spaceBetween: 20 },
        1024: { slidesPerView: slidesPerViewDesktop, spaceBetween: 32 },
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
