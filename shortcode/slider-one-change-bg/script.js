jQuery(document).ready(function ($) {
  //   class wrap: .pt-slide-center-img

  $('.pt-slide-one-change-bg').each(function (indexInArray, parent) {
    let wrapper = $(parent)
    let autoSlide = Number(wrapper.data('auto-slide'))
    let autoHeight = Boolean(wrapper.data('auto-height'))
    let swipperEl = wrapper.find('.ptSwiperOneChangeBg')

    // Function để update background image
    function updateBackgroundImage(activeIndex) {
      wrapper.find('.el-bgs .el-bg').removeClass('active')
      wrapper.find('.el-bgs .el-bg').eq(activeIndex).addClass('active')
    }

    if (!swipperEl[0]) return

    // Set up progress circle
    const progressCircle = wrapper[0].querySelector('.autoplay-progress svg')
    const progressContent = wrapper[0].querySelector('.autoplay-progress span')
    
    if (Number.isNaN(autoSlide) || autoSlide === 0) {
      wrapper.find('.autoplay-progress').hide()
    }
    // required slide item have w= real px
    var swiper = new Swiper(swipperEl[0], {
      slidesPerView: 1,
      loop: true,
      centeredSlides: true,
      spaceBetween: 20,
      allowTouchMove: true,
      grabCursor: true,
      autoHeight: autoHeight,
      speed: 500, // Tăng thời gian transition để mượt hơn
      pagination: {
        el: '.swiper-pagination',
        dynamicBullets: true,
        clickable: true,
      },
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      autoplay:
        Number.isNaN(autoSlide) || autoSlide === 0
          ? false
          : {
              delay: autoSlide,
              disableOnInteraction: false,
              pauseOnMouseEnter: true,
            },
      on: {
        init: function () {
          // Set background cho slide đầu tiên khi khởi tạo
          updateBackgroundImage(this.realIndex)
        },
        slideChange: function () {
          // Update background khi slide thay đổi
          updateBackgroundImage(this.realIndex)
        },
        autoplayTimeLeft(s, time, progress) {
          if (!progressCircle || !progressContent) return
          progressCircle.style.setProperty('--progress', 1 - progress)
          progressContent.textContent = `${Math.ceil(time / 1000)}s`
        },
      },
    })
  })
})
