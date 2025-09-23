document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.carouselSwiper').forEach((root) => {
    const wrapper = root.closest('.carousel-wrapper'); 
    const nextBtn = wrapper.querySelector('.carousel-button-next');
    const prevBtn = wrapper.querySelector('.carousel-button-prev'); 

    const swiper = new Swiper(root, {
      slidesPerView: 4,
      loop: true,
      speed: 500,
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
        768:  { slidesPerView: 2.3,  slidesOffsetBefore: 65, spaceBetween: 26 },
        1024: { slidesPerView: 4, spaceBetween: 32 },
      },
    });

  
  });

  document.addEventListener('click', function (e) {
    const nextBtn = e.target.closest('.carousel-button-next');
    if (!nextBtn) return;
    const wrapper = nextBtn.closest('.carousel-wrapper'); 
    if (wrapper) wrapper.classList.add('has-seen-prev');
  });
});
