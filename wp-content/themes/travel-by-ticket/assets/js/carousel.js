document.addEventListener('DOMContentLoaded', function() {
    const swiper = new Swiper('.carouselSwiper', {
      slidesPerView: 3,
      loop: true,
      lazy: {
        enabled: true,          
        loadPrevNext: true,   
        loadPrevNextAmount: 1, 
        loadOnTransitionStart: true, 
      },
      navigation: {
        nextEl: '.carousel-button-next',
        prevEl: '.carousel-button-prev',
      },
      breakpoints: {
        320: {
          spaceBetween: 20,
          slidesPerView: 1.21, 
          slidesOffsetBefore: 40,
        },
        768: {
          slidesPerView: 2.3, 
          slidesOffsetBefore: 65,

        },
        1024: {
          slidesPerView: 4,
          spaceBetween: 30
        },
      },
    });
  
});
  