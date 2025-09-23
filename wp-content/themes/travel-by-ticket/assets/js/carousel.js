document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.carouselSwiper').forEach((root) => {
    const swiperEl = root;
    const nextBtn  = root.querySelector('.carousel-button-next svg > g');
    const prevBtn  = root.querySelector('.carousel-button-prev svg > g');

    const swiper = new Swiper(swiperEl, {
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
        320:  { spaceBetween: 20, slidesPerView: 1.21, slidesOffsetBefore: 40 },
        768:  { slidesPerView: 2.3,  slidesOffsetBefore: 65 },
        1024: { slidesPerView: 4,    spaceBetween: 30 },
      },
    });

    //Autoslide how navigation button
    swiper.on('slideNextTransitionStart', () => root.classList.add('has-seen-prev'));
  });

  document.addEventListener('click', function (e) {
    const nextBtn = e.target.closest('.carousel-button-next');
    if (!nextBtn) return;
    const root = nextBtn.closest('.carouselSwiper');
    if (root) root.classList.add('has-seen-prev');
  });
});
