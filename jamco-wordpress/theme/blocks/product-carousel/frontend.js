/**
 * Product Carousel Frontend JavaScript
 */
document.addEventListener('DOMContentLoaded', function() {
  const carousels = document.querySelectorAll('.product-carousel');

  carousels.forEach(carousel => {
    const track = carousel.querySelector('.carousel-track');
    const items = carousel.querySelectorAll('.carousel-item');
    const prevBtn = carousel.querySelector('.carousel-prev');
    const nextBtn = carousel.querySelector('.carousel-next');
    const currentSpan = carousel.querySelector('.carousel-pagination .current');
    const totalSpan = carousel.querySelector('.carousel-pagination .total');

    if (!track || items.length === 0) return;

    let currentIndex = 0;
    const totalItems = items.length;

    // Update pagination total
    if (totalSpan) {
      totalSpan.textContent = String(totalItems).padStart(2, '0');
    }

    function updateCarousel() {
      // Calculate scroll position (assuming items are 400px + gap)
      const itemWidth = items[0].offsetWidth;
      const gap = parseInt(getComputedStyle(track).gap) || 24;
      const scrollAmount = (itemWidth + gap) * currentIndex;

      track.style.transform = `translateX(-${scrollAmount}px)`;

      // Update pagination
      if (currentSpan) {
        currentSpan.textContent = String(currentIndex + 1).padStart(2, '0');
      }

      // Update button states
      if (prevBtn) {
        prevBtn.disabled = currentIndex === 0;
      }
      if (nextBtn) {
        nextBtn.disabled = currentIndex === totalItems - 1;
      }
    }

    function goToSlide(index) {
      currentIndex = Math.max(0, Math.min(index, totalItems - 1));
      updateCarousel();
    }

    function nextSlide() {
      goToSlide(currentIndex + 1);
    }

    function prevSlide() {
      goToSlide(currentIndex - 1);
    }

    // Event listeners
    if (nextBtn) {
      nextBtn.addEventListener('click', nextSlide);
    }
    if (prevBtn) {
      prevBtn.addEventListener('click', prevSlide);
    }

    // Keyboard navigation
    carousel.addEventListener('keydown', (e) => {
      if (e.key === 'ArrowLeft') {
        prevSlide();
      } else if (e.key === 'ArrowRight') {
        nextSlide();
      }
    });

    // Initialize
    updateCarousel();

    // Handle window resize
    let resizeTimeout;
    window.addEventListener('resize', () => {
      clearTimeout(resizeTimeout);
      resizeTimeout = setTimeout(updateCarousel, 250);
    });
  });
});
