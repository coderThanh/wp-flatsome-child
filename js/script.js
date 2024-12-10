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
              if (maxHeight <= $(listChild[index]).height()) {
                maxHeight = $(listChild[index]).height()
              }
            }
            for (let index = 0; index < listChild.length; ++index) {
              $(listChild[index]).height(maxHeight)
            }

            $(makeElement)
              ?.find('.flickity-viewport')
              ?.css('min-height', maxHeight)
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
          if (maxHeight <= $(listChild[index]).height()) {
            maxHeight = $(listChild[index]).height()
          }
        }

        for (let index = 0; index < listChild.length; ++index) {
          $(listChild[index]).height(maxHeight)
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
const ptHandleCloseBoxOptions = (
  event,
  classWrap,
  fnRemove,
  classRemove = 'active',
) => {
  // event.preventDefault()

  var wrapEl = event.target.closest(`.${classWrap}`)

  if (event.target.classList.contains(classWrap) || wrapEl) {
    return
  }

  document
    .querySelectorAll(`.${classWrap}.${classRemove}`)
    .forEach((item) => item.classList.remove(classRemove))

  document.removeEventListener('click', fnRemove)
}

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

handleTabNavToSwiper()
