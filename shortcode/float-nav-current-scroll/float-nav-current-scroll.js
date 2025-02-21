jQuery(document).ready(function ($) {
  $('.float-nav-current-scroll').each(function (indexInArray, rootElement) {
    // run swiper
    let swiper = new Swiper('.swiper', {
      slidesPerView: 'auto',
      spaceBetween: 0,
      loop: false,
      freeMode: {
        enabled: true,
      },
    })

    const handleSticky = () => {
      const rootElementTop = rootElement.getBoundingClientRect().top
      const rootElementHeight = rootElement.getBoundingClientRect().height

      $(rootElement).height(rootElementHeight)

      if (rootElementTop <= 0) {
        $(rootElement).addClass('is-sticky')

        return
      }

      $(rootElement).removeClass('is-sticky')
    }

    document.addEventListener('scroll', function () {
      handleSticky()
    })
  })
})
