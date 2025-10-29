document.querySelectorAll('.scroll-container').forEach(container => {
  let isDown = false;
  let startX;
  let scrollLeft;
  let moved = false;
  const DRAG_THRESHOLD = 5; 

  container.addEventListener('mousedown', (e) => {
    isDown = true;
    moved = false;
    container.classList.add('active');
    startX = e.pageX - container.offsetLeft;
    scrollLeft = container.scrollLeft;
  });

  container.addEventListener('mouseleave', () => {
    isDown = false;
    container.classList.remove('active');
  });

  container.addEventListener('mouseup', () => {
    isDown = false;
    container.classList.remove('active');
  });

  container.addEventListener('mousemove', (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - container.offsetLeft;
    const walk = (x - startX) * 1.5;
    if (Math.abs(x - startX) > DRAG_THRESHOLD) moved = true;
    container.scrollLeft = scrollLeft - walk;
  });

  container.addEventListener('click', (e) => {
    if (moved) {
      e.preventDefault();
      e.stopPropagation();
      moved = false;       
    }
  }, true); 

  container.addEventListener('wheel', (e) => {
    if (e.deltaY !== 0) {
      e.preventDefault();
      container.scrollLeft += e.deltaY * 1.5;
    }
  }, { passive: false });

  let tStartX, tScrollLeft;
  container.addEventListener('touchstart', (e) => {
    isDown = true;
    moved = false;
    tStartX = e.touches[0].clientX;
    tScrollLeft = container.scrollLeft;
  }, { passive: true });

  container.addEventListener('touchmove', (e) => {
    if (!isDown) return;
    const x = e.touches[0].clientX;
    const walk = (x - tStartX) * 1.5;
    if (Math.abs(x - tStartX) > DRAG_THRESHOLD) moved = true;
    container.scrollLeft = tScrollLeft - walk;
  }, { passive: true });

  container.addEventListener('touchend', () => {
    isDown = false;
  }, { passive: true });
});
