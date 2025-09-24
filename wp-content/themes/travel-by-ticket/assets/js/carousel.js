document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.carouselSwiper').forEach((root) => {
    const wrapper = root.closest('.carousel-wrapper'); 
    const nextBtn = wrapper.querySelector('.carousel-button-next');
    const prevBtn = wrapper.querySelector('.carousel-button-prev'); 

    const swiper = new Swiper(root, {
      slidesPerView: 4,
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
        320:  { slidesPerView: 1.21, spaceBetween: 20 },
        768:  { slidesPerView: 3, spaceBetween: 20 },
        1024: { slidesPerView: 4, spaceBetween: 32 },
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
