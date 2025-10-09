// -----
// Animate scroll scale small to up
(function(){
  // Khởi tạo GSAP ScrollTrigger cho hiệu ứng scroll scale
  document.addEventListener('DOMContentLoaded', function(){
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
      console.warn('GSAP hoặc ScrollTrigger chưa được tải.');
      return;
    }

    gsap.registerPlugin(ScrollTrigger);

    var elements = document.querySelectorAll('.ani-scroll-scale-small-to-up');
    if (!elements || !elements.length) return;

    elements.forEach(function(el){
      // Từ scale nhỏ -> lớn khi scroll
      gsap.fromTo(
        el,
        { scale: 0.85, transformOrigin: 'center center' },
        {
          scale: 1,
          ease: 'none',
          scrollTrigger: {
            trigger: el,
            // Bắt đầu: bottom window + top element
            start: 'top bottom',
            // Kết thúc: bottom window + bottom element
            end: 'bottom bottom',
            scrub: true,
          }
        }
      );
    });
  });
})();