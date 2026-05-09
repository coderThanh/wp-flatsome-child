//
function initSwiperDefault() {
  jQuery(document).ready(function ($) {
    $('.swiper-default').each(function (indexInArray, swiperEletment) {
      // get config
      let sliderPerViewSm = Number.isNaN(
        Number($(this).data('slider-per-view')),
      )
        ? 1
        : Number($(this).data('slider-per-view'))

      let sliderPerViewMd = Number.isNaN(
        Number($(this).data('slider-per-view-md')),
      )
        ? 1
        : Number($(this).data('slider-per-view-md'))

      let sliderPerViewLg = Number.isNaN(
        Number($(this).data('slider-per-view-lg')),
      )
        ? 1
        : Number($(this).data('slider-per-view-lg'))

      let autoPlay = Number.isNaN(Number($(this).data('auto-play')))
        ? null
        : Number($(this).data('auto-play'))
      let spaceBetween = Number.isNaN(Number($(this).data('space-between')))
        ? 0
        : Number($(this).data('space-between'))
      let loop = Boolean($(this).data('loop'))
      let autoHeight = Boolean($(this).data('auto-height'))

      if (!swiperEletment) return

      // init swiper default
      new Swiper(swiperEletment, {
        spaceBetween: spaceBetween,
        loop: loop,
        autoHeight: autoHeight,
        autoplay: autoPlay
          ? { delay: autoPlay, pauseOnMouseEnter: true, disableOnInteraction: false }
          : false,
        breakpoints: {
          0: {
            slidesPerView: sliderPerViewSm,
          },
          576: {
            slidesPerView: sliderPerViewMd ?? sliderPerViewSm,
          },
          768: {
            slidesPerView:
              sliderPerViewLg ?? sliderPerViewMd ?? sliderPerViewSm,
          },
        },
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },
      })
    })
  })
}
initSwiperDefault()
