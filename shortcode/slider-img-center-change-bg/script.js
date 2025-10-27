jQuery(document).ready(function ($) {
  //   class wrap: .pt-slide-center-img

  $('.pt-slide-center-img').each(function (indexInArray, parent) {
    let wrapper = $(parent)
    let autoSlide = Number(wrapper.data('auto-slide'))
    let swipperEl = wrapper.find('.ptSwiperCenterImg')

    // Function để update background image
    function updateBackgroundImage(activeIndex) {
      wrapper.find('.el-bgs .el-bg').removeClass('active')
      wrapper.find('.el-bgs .el-bg').eq(activeIndex).addClass('active')
    }

    if (!swipperEl[0]) return

    if (Number.isNaN(autoSlide) || autoSlide === 0) {
      wrapper.find('.autoplay-progress').hide()
    }

    const progressCircle = wrapper[0].querySelector('.autoplay-progress svg')
    const progressContent = wrapper[0].querySelector('.autoplay-progress span')
    // required slide item have w= real px
    var swiper = new Swiper(swipperEl[0], {
      slidesPerView: 'auto',
      // loop: true,
      centeredSlides: true,
      spaceBetween: 20,
      observer: true,
      observeParents: true,
      allowTouchMove: true,
      grabCursor: true,
      speed: 500, // Tăng thời gian transition để mượt hơn
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
          progressCircle.style.setProperty('--progress', 1 - progress)
          progressContent.textContent = `${Math.ceil(time / 1000)}s`
        },
      },
    })

    // Trước khi chuyển slide → set lại width trước
    swiper.off('slideChangeTransitionStart')
    swiper.on('slideChangeTransitionStart', () => {
      swiper.update()
    })
  })
})
