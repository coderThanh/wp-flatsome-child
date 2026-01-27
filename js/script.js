/** Handle Content view more  -------- */
function handleContentViewMore() {
  jQuery(document).ready(function ($) {
    // if ($('.single-product .panel.entry-content').length > 0) {
    // }

    var your_height = 450

    $('.single-product .panel.entry-content').each(function (
      indexInArray,
      parentEL,
    ) {
      var wrap = $(parentEL)
      var current_height = wrap.height()

      if (current_height > your_height) {
        wrap.css('height', your_height + 'px')

        wrap.addClass('content-box-loadmore')

        wrap.append(function () {
          return '<div class="pt_content_btn_loadmore"><div title="Xem thêm" class="btn-loadmore" ><span>Xem thêm</span></div></div>'
        })

        $('body').on(
          'click',
          '.pt_content_btn_loadmore .btn-loadmore',
          function () {
            $(this).closest('.content-box-loadmore').removeAttr('style')
            $(this).closest('.pt_content_btn_loadmore').remove()
          },
        )
      }
    })
  })
}

// handleContentViewMore()

/** Handle Header menu-item overflow to hidden */
function handleHeaderMenuItemOverLow() {
  jQuery(document).ready(function ($) {
    $('header .header-nav-main').each(function (indexInArray, parentEl) {
      // reset
      $(parentEl)
        .find('> .menu-item')
        .each(function (indexInArray, valueOfElement) {
          $(valueOfElement).removeClass('hidden')
        })

      const outerWidth = $(parentEl).outerWidth(false)
      const parrent = parentEl.getBoundingClientRect()

      var indexStartHidden
      var wasSetIndex = false

      $(parentEl)
        .find('> .menu-item')
        .each(function (indexInArray, valueOfElement) {
          const box = valueOfElement.getBoundingClientRect()

          if (
            box.left < 0 ||
            (box.right > outerWidth + parrent.left && !wasSetIndex)
          ) {
            indexStartHidden = indexInArray
            wasSetIndex = true
          }
        })

      $(parentEl)
        .find('> .menu-item')
        .each(function (indexInArray, valueOfElement) {
          if (indexInArray >= indexStartHidden) {
            $(valueOfElement).addClass('hidden')
          }
        })
    })
  })
}

// handleHeaderMenuItemOverLow()
// window.addEventListener('resize', handleHeaderMenuItemOverLow)

/**
 * Make box child euqal
 */

jQuery(document).ready(function ($) {
  // run init
  // setTimeout(setEqualForBox, 0)
  setEqualForBox()
  setEqualForBoxInSlider()

  // run when change windown width
  window.addEventListener('resize', function (event) {
    setEqualForBox()
    setEqualForBoxInSlider()
  })
})

function setEqualForBoxInSlider() {
  jQuery(document).ready(function ($) {
    $('.make-box-equal-slider').each(async function (
      indexInArray,
      makeElement,
    ) {
      var countInterval = 0
      const intervalID = setInterval(() => {
        countInterval += 1

        if (countInterval > 1200) {
          console.warn(
            'setEqualForBoxInSlider - call many time interval',
            makeElement,
          )
        }

        if ($(makeElement)?.find('.flickity-viewport')?.css('height')) {
          clearInterval(intervalID)

          var maxHeight = 0
          var listChild = $(makeElement).find('.box')
          if (listChild.length > 0) {
            for (let index = 0; index < listChild.length; ++index) {
              $(listChild[index]).css('height', '')
            }
            for (let index = 0; index < listChild.length; ++index) {
              if (maxHeight <= $(listChild[index]).outerHeight()) {
                maxHeight = $(listChild[index]).outerHeight()
              }
            }
            $(makeElement).find('.box').outerHeight(maxHeight)
            $(makeElement)
              ?.find('.flickity-viewport')
              ?.css('min-height', maxHeight )
          }
        }
      }, 600)
    })
  })
}

function setEqualForBox() {
  jQuery(document).ready(function ($) {
    $('.make-box-equal').each(async function (indexInArray, makeElement) {
      var maxHeight = 0

      var listChild = $(makeElement).find('.box')

      if (listChild.length > 0) {
        for (let index = 0; index < listChild.length; ++index) {
          $(listChild[index]).css('height', '')
        }

        for (let index = 0; index < listChild.length; ++index) {
          if (maxHeight <= $(listChild[index]).outerHeight()) {
            maxHeight = $(listChild[index]).outerHeight()
          }
        }

        for (let index = 0; index < listChild.length; ++index) {
          $(listChild[index]).outerHeight(maxHeight)
        }
      }
    })
  })
}

/**
 *
 */
function handleNoTranslateGoogle() {
  jQuery(document).ready(function ($) {
    $('.page-numbers').$.each(function (indexInArray, valueOfElement) {
      $(valueOfElement).attr('translate', 'no')
    })
  })
}

// handleHeaderMenuItemOverLow()

// window.addEventListener('resize', handleHeaderMenuItemOverLow)


/**
 * Init swiper for tab navigation.
 *
 * This function will rebuild the tab navigation layout and add swiper to it.
 *
 * @since 1.0.0
 */
function handleTabNavToSwiper() {
  jQuery(document).ready(function ($) {
    $('.tab-nav-slider').each(function (indexInArray, parentEL) {
      const rebuildLayout = () => {
        const divSwiper = document.createElement('div')
        divSwiper.classList.add('swiper')
        divSwiper.classList.add('swiper-tab-nav')

        const divSwiperWrapper = document.createElement('div')
        divSwiperWrapper.classList.add('swiper-wrapper')

        $(parentEL)
          .find('.nav .tab')
          .each(function (indexInArray, valueOfElement) {
            const divSwiperSlide = document.createElement('ul')
            divSwiperSlide.classList.add('swiper-slide')
            divSwiperWrapper.append(divSwiperSlide)
            divSwiperSlide.append(valueOfElement)
          })

        $(parentEL).prepend(divSwiper)
        $(parentEL).find('.swiper').append(divSwiperWrapper)
        $(parentEL).find('> .nav').remove()
      }

      const runSwiper = () => {
        const swiper = new Swiper($(parentEL).find('.swiper')[0], {
          speed: 400,
          spaceBetween: 0,
          autoHeight: false,
          freeMode: true,
          slidesPerView: 'auto',
        })
      }

      //
      rebuildLayout()
      runSwiper()
    })
  })
}

// handleTabNavToSwiper()

/**
 * Handle click event for video controller.
 *
 * This function will add event listeners to video controller elements.
 *
 * @since 1.0.0
 */
function handleVideoController() {
  jQuery(document).ready(function ($) {
    $('.section-video-controll').each(function (indexInArray, parentEL) {
      var video = $(parentEL).find('.video-bg')[0]

      if (!video) return

      $(parentEL)
        .find('.el-icon-pause')
        .on('click', function (event) {
          event.preventDefault()

          $(this).addClass('hidden')

          $(parentEL).find('.el-icon-play').removeClass('hidden')

          video.pause()
        })

      $(parentEL)
        .find('.el-icon-play')
        .on('click', function (event) {
          event.preventDefault()

          $(this).addClass('hidden')

          $(parentEL).find('.el-icon-pause').removeClass('hidden')

          video.play()
        })

      $(parentEL)
        .find('.el-icon-music')
        .on('click', function (event) {
          event.preventDefault()

          $(this).addClass('hidden')

          $(parentEL).find('.el-icon-muted').removeClass('hidden')

          video.muted = false
        })

      $(parentEL)
        .find('.el-icon-muted')
        .on('click', function (event) {
          event.preventDefault()

          $(this).addClass('hidden')

          $(parentEL).find('.el-icon-music').removeClass('hidden')

          video.muted = true
        })
    })
  })
}

//
const handleToolTipOn = (event) => {
  jQuery(document).ready(function ($) {
    const parentElement = $(event.target)
    const tooltipBoxRight = parentElement.find('.tooltip_box-right')
    const tooltipBox = tooltipBoxRight.length
      ? tooltipBoxRight
      : parentElement.find('.tooltip_box')

    const windowWidth = $(window).width()
    const windowHeight = $(window).height()
    const parentOffset = parentElement.offset()
    const parentWidth = parentElement.outerWidth()
    const tooltipWidth = tooltipBox.outerWidth()
    const tooltipHeight = tooltipBox.outerHeight()

    let left, top

    if (tooltipBoxRight.length) {
      // Center-right: tooltip nằm giữa bên phải phần tử cha, top theo vị trí chuột
      left = parentOffset.left + parentWidth + 12
      top = event.clientY - tooltipHeight / 2

      // Nếu vượt phải màn hình thì đẩy sát mép phải
      if (left + tooltipWidth > windowWidth) {
        left = windowWidth - tooltipWidth - 8
      }
      // Nếu vượt trên/dưới thì căn lại
      if (top < 0) top = 8
      if (top + tooltipHeight > windowHeight)
        top = windowHeight - tooltipHeight - 8
    } else {
      // Top-center: tooltip nằm phía trên, căn giữa phần tử cha, top theo vị trí chuột
      left = parentOffset.left + parentWidth / 2 - tooltipWidth / 2
      top = event.clientY - tooltipHeight - 12

      // Nếu vượt trái/phải màn hình thì căn lại
      if (left < 0) left = 8
      if (left + tooltipWidth > windowWidth)
        left = windowWidth - tooltipWidth - 8
      // Nếu vượt trên màn hình thì đặt xuống dưới vị trí chuột
      if (top < 0) top = event.clientY + 12
      if (top + tooltipHeight > windowHeight)
        top = windowHeight - tooltipHeight - 8
    }

    tooltipBox
      .css({
        position: 'fixed',
        left: left + 'px',
        top: top + 'px',
        zIndex: 1000,
        display: 'block',
      })
      .addClass('show')
  })
}

const handleToolTipLeave = (event) => {
  jQuery(document).ready(function ($) {
    const parentElement = $(event.target)
    const tooltipBox = parentElement.find('.tooltip_box')

    tooltipBox.css({ display: 'none' }).removeClass('show')
  })
}


// Horizontal scroll animation for .can-scroll-vertical
function addHorizontalScroll(el) {
  var isDown = false
  var startX
  var scrollLeft
  var lastScrollLeft
  var rafId
  var velocity = 0
  var momentum = false

  function animateMomentum(element) {
    if (!momentum) return
    velocity *= 0.95
    if (Math.abs(velocity) > 0.5) {
      element.scrollLeft += velocity
      rafId = requestAnimationFrame(function () {
        animateMomentum(element)
      })
    } else {
      momentum = false
      velocity = 0
      cancelAnimationFrame(rafId)
    }
  }

  el.addEventListener('mousedown', function (e) {
    isDown = true
    startX = e.pageX - el.offsetLeft
    scrollLeft = el.scrollLeft
    lastScrollLeft = el.scrollLeft
    velocity = 0
    momentum = false
  })
  el.addEventListener('mouseleave', function () {
    isDown = false
    el.classList.remove('scrolling')
    if (velocity !== 0) {
      momentum = true
      animateMomentum(el)
    }
  })
  el.addEventListener('mouseup', function () {
    isDown = false
    el.classList.remove('scrolling')
    if (velocity !== 0) {
      momentum = true
      animateMomentum(el)
    }
  })
  el.addEventListener('mousemove', function (e) {
    if (!isDown) return
    e.preventDefault()
    e.stopPropagation()
    el.classList.add('scrolling')
    var x = e.pageX - el.offsetLeft
    var walk = x - startX
    el.scrollLeft = scrollLeft - walk
    velocity = el.scrollLeft - lastScrollLeft
    lastScrollLeft = el.scrollLeft
  })
  // Touch events
  el.addEventListener('touchstart', function (e) {
    isDown = true
    startX = e.touches[0].pageX - el.offsetLeft
    scrollLeft = el.scrollLeft
    lastScrollLeft = el.scrollLeft
    velocity = 0
    momentum = false
  })
  el.addEventListener('touchend', function () {
    isDown = false
    el.classList.remove('scrolling')
    if (velocity !== 0) {
      momentum = true
      animateMomentum(el)
    }
  })
  el.addEventListener('touchmove', function (e) {
    if (!isDown) return
    e.preventDefault()
    e.stopPropagation()
    el.classList.add('scrolling')
    var x = e.touches[0].pageX - el.offsetLeft
    var walk = x - startX
    el.scrollLeft = scrollLeft - walk
    velocity = el.scrollLeft - lastScrollLeft
    lastScrollLeft = el.scrollLeft
  })
}


document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.can-scroll-vertical').forEach(function (el) {
    addHorizontalScroll(el)
  })
})
