function runWPEditorGalleryToMansorySwipper() {
  jQuery(document).ready(function ($) {
    // run mansory lib
    $('.entry-content .gallery, .portfolio-inner .gallery ').masonry({
      itemSelector: '.gallery-item',
      columnWidth: '.gallery-item',
      percentPosition: true,
    })

    // run popup slider
    var imgs = $('.gallery .gallery-item img').toArray() || []

    const elMainWrap = document.getElementById('wrapper')

    // init swipper
    var elSwiper = document.createElement('div')
    elSwiper.setAttribute('class', 'swiper gallery-full-screen')

    var elSwiperWrapper = document.createElement('div')
    elSwiperWrapper.setAttribute('class', 'swiper-wrapper')

    var elSwiperBtnPrev = document.createElement('div')
    elSwiperBtnPrev.setAttribute('class', 'swiper-button-prev')

    var elSwiperBtnNext = document.createElement('div')
    elSwiperBtnNext.setAttribute('class', 'swiper-button-next')

    elSwiper.appendChild(elSwiperWrapper)
    elSwiper.appendChild(elSwiperBtnPrev)
    elSwiper.appendChild(elSwiperBtnNext)

    for (let i = 0; i < imgs?.length; i++) {
      let item = imgs[i]

      if (!item.getAttribute('src')) {
        continue
      }

      let elSwiperSlide = document.createElement('div')
      elSwiperSlide.setAttribute('class', 'swiper-slide')

      let elFifcaption = ''

      if (item.getAttribute('alt')) {
        elFifcaption = `<figcaption>${item.getAttribute('alt')}</figcaption>`
      }

      elSwiperSlide.innerHTML = `<div class="swiper-slide-inner"><img alt="${item.getAttribute(
        'alt',
      )}" src="${item.getAttribute('src')}"/>${elFifcaption}</div>`

      elSwiperWrapper.appendChild(elSwiperSlide)
    }

    // init popup element

    var elPopupWrap = document.createElement('div')
    elPopupWrap.setAttribute(
      'class',
      'pt-popup-wrap  popup-gallery-full-screen',
    )

    var elPopupInner = document.createElement('div')
    elPopupInner.setAttribute('class', 'pt-popup-inner')

    var elPopupContent = document.createElement('div')
    elPopupContent.setAttribute('class', 'pt-popup-content')

    var elPopupBg = document.createElement('div')
    elPopupBg.setAttribute('class', 'pt-popup-bg')
    elPopupBg.addEventListener('click', ptPopUpClose)

    var elPopupBtnClose = document.createElement('div')
    elPopupBtnClose.setAttribute('class', 'pt-popup-btn-close')
    elPopupBtnClose.addEventListener('click', ptPopUpClose)

    var elPopupBtnCloseText = document.createElement('span')
    elPopupBtnCloseText.setAttribute('class', 'material-symbols-outlined')
    elPopupBtnCloseText.innerText = 'close'

    // add content for popup
    elPopupBtnClose.appendChild(elPopupBtnCloseText)

    elPopupContent.appendChild(elSwiper)

    elPopupInner.appendChild(elPopupBtnClose)
    elPopupInner.appendChild(elPopupBg)
    elPopupInner.appendChild(elPopupContent)

    elPopupWrap.appendChild(elPopupInner)

    elMainWrap.appendChild(elPopupWrap)

    // run Swiper
    let swiper = new Swiper('.gallery-full-screen', {
      slidesPerView: 1,
      autoHeight: true,
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    })

    // handle event click popup
    for (let i = 0; i < imgs?.length; i++) {
      let item = imgs[i]

      if (!item.getAttribute('src')) {
        continue
      }

      imgs[i].addEventListener('click', (event) => {
        const indexSlideClick = imgs.findIndex((item) => {
          return event.target.getAttribute('src') == item.getAttribute('src')
        })

        swiper.slideTo(indexSlideClick == -1 ? 0 : indexSlideClick, 0)

        elPopupWrap.setAttribute(
          'class',
          elPopupWrap.getAttribute('class') + ' show',
        )
      })
    }
  })
}

runWPEditorGalleryToMansorySwipper()
