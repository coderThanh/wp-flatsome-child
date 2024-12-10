const swiper = new Swiper('.ytb-slider-area .swiper', {
  slidesPerView: 'auto',
  direction: 'vertical',
})

jQuery(document).ready(function ($) {
  $('.ytb-slider-area').each(function (indexInArray, wrapEL) {
    $(wrapEL)
      .find('.ytb-thumb')
      .click(function (e) {
        // e.preventDefault();

        var id = $(this).attr('data-id')
        var index = $(this).attr('data-index')
        var title = $(this).attr('data-title')

        // change iframe
        var newIframe = `<iframe src="https://www.youtube.com/embed/${id}" title="${title}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>`

        $(wrapEL).find('.ytb-iframe-inner').html(newIframe)

        $(wrapEL).find('.ytb-thumb').removeClass('active')

        $(this).addClass('active')

        // Change slider
        swiperToIndex(index)
      })
  })

  //
  const swiperToIndex = (index) => {
    if (!index) return

    if (index >= 2) {
      swiper.slideTo(index - 1)

      return
    }

    if (index == 1) {
      swiper.slideTo(0)

      return
    }

    swiper.slideTo(index)
  }
})
