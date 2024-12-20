/**
 * Animation script
 */

/**
 * Scroll reveal class
 class: reveal-in-slider-up-wrap , reveal-up-wrap
 */

// Requrie css
// html:not([ng-app="uxBuilder"])  .reveal-up-wrap {
// 	visibility: hidden;
// 	transition: unset;
// }

// html:not([ng-app="uxBuilder"])  .reveal-in-slider-up-wrap {
// 	opacity: 0;
// 	transition: unset;
// }

function runScrollRevealElement() {
  const configRevealUp = {
    duration: 600,
    distance: '50px',
    interval: 400,
    delay: 100,
  }

  // Out slider
  var nodeArray = document.querySelectorAll('.reveal-up-wrap')

  ScrollReveal().reveal(nodeArray, configRevealUp)

  // if in slider
  jQuery(document).ready(function ($) {
    $('.slider').each(function (indexInArray, wrapEl) {
      var nodeArray = wrapEl.querySelectorAll('.reveal-in-slider-up-wrap')

      if (!nodeArray?.length) return

      var isShowAll = false

      // create an observer instance
      var observer = new IntersectionObserver(function (entries) {
        entries.forEach((entry) => {
          // TO DO

          if (entry.isIntersecting && !isShowAll) {
            var animation = anime({
              targets: nodeArray,
              translateY: [50, 0],
              opacity: [0, 1],
              duration: 600,
              delay: function (el, i) {
                return i * 200
              },
              direction: 'alternate',
              loop: 0,
              autoplay: true,
              easing: 'linear',
            })

            animation.finished.then(() => {
              isShowAll = true
              observer.disconnect()
            })
          }
        })
      }, {})

      observer.observe(wrapEl)
    })
  })
}

jQuery(document).ready(function ($) {
  runScrollRevealElement()
})

function runAnimationFade() {
  jQuery(document).ready(function ($) {
    //
    $('.text-fade-up').each(function (indexInArray, fadeWrap) {
      var isFaded = $(fadeWrap).attr('data-is-faded')

      if (!isFaded) {
        $(fadeWrap).attr('data-is-faded', 'false')
      }

      $(fadeWrap)
        .find('h1, h2, h3, h4, h5, h6, p, .button')
        .each(function (indexInArray, childElement) {
          $(childElement).wrap("<div class='child' style='opacity:0;'></div>")
        })

      var isFaded = $(fadeWrap).attr('data-is-faded')

      if (isInViewport(fadeWrap) && !isFaded) {
        $(fadeWrap).attr('data-is-faded', 'true')

        setTimeout(function () {
          textWrapFadeUp(fadeWrap)
        }, 400)
      }
    })

    $('.text-fade-down').each(function (indexInArray, fadeWrap) {
      var isFaded = $(fadeWrap).attr('data-is-faded')

      if (!isFaded) {
        $(fadeWrap).attr('data-is-faded', 'false')
      }

      $(fadeWrap)
        .find('h1, h2, h3, h4, h5, h6, p, .button')
        .each(function (indexInArray, childElement) {
          $(childElement).wrap("<div class='child' style='opacity:0;'></div>")
        })

      var isFaded = $(fadeWrap).attr('data-is-faded')

      if (isInViewport(fadeWrap) && !isFaded) {
        $(fadeWrap).attr('data-is-faded', 'true')

        setTimeout(function () {
          textWrapFadeDown(fadeWrap)
        }, 400)
      }
    })

    // Animation fade text left
    $('.text-fade-left').each(function (indexInArray, fadeWrap) {
      var isFaded = $(fadeWrap).attr('data-is-faded')

      if (!isFaded) {
        $(fadeWrap).attr('data-is-faded', 'false')
      }

      $(fadeWrap)
        .find('h1, h3, h2')
        .each(function (indexInArray, valueOfElement) {
          $(valueOfElement).html(
            $(valueOfElement)
              .html()
              .replace(
                /\S/g,
                "<span style='opacity:0;' class='letter'>$&</span>",
              ),
          )
        })

      $(fadeWrap)
        .find(' h4, h5, h6, p, .button')
        .each(function (indexInArray, childElement) {
          $(childElement).wrap("<div class='child' style='opacity:0;'></div>")
        })

      if (isInViewport(fadeWrap) && !isFaded) {
        $(fadeWrap).attr('data-is-faded', 'true')

        setTimeout(function () {
          textWrapFadeLeft(fadeWrap)
        }, 400)
      }
    })

    /**
     * Animejs fade its rotate
     */
    $('.it-fade-rotate').each(function (indexInArray, fadeWrap) {
      var isFaded = $(fadeWrap).attr('data-is-faded')

      if (!isFaded) {
        $(fadeWrap).attr('data-is-faded', 'false')
      }

      $(fadeWrap).html("<div class='child'>" + $(fadeWrap).html() + '</div>')

      $(fadeWrap).find('.child').css({ opacity: 0 })

      if (isInViewport(fadeWrap) && !isFaded) {
        $(fadeWrap).attr('data-is-faded', 'true')

        setTimeout(function () {
          textFadeRote(fadeWrap)
        }, 600)
      }
    })

    //
    $('.img-wrap-fade-right').each(function (indexInArray, fadeWrap) {
      var isFaded = $(fadeWrap).attr('data-is-faded')

      if (!isFaded) {
        $(fadeWrap).attr('data-is-faded', 'false')
      }

      $(fadeWrap)
        .find('.img-fade-child')
        .each(function (indexInArray, childElement) {
          $(childElement).css({ opacity: 0 })
        })

      if (isInViewport(fadeWrap) && !isFaded) {
        $(fadeWrap).attr('data-is-faded', 'true')

        setTimeout(function () {
          imgWrapFadeRight(fadeWrap)
        }, 500)
      }
    })

    /**
     * Windown on scroll
     * Hook action
     */
    $(window).scroll(function () {
      // Animejs fade timage right run
      $('.img-wrap-fade-right').each(function (indexInArray, fadeWrap) {
        var isFaded = $(fadeWrap).attr('data-is-faded')

        if (isInViewport(fadeWrap) && isFaded == 'false') {
          imgWrapFadeRight(fadeWrap)
        }
      })

      // Animationjs fade text up run
      $('.text-fade-up').each(function (indexInArray, fadeWrap) {
        var isFaded = $(fadeWrap).attr('data-is-faded')

        if (isInViewport(fadeWrap) && isFaded == 'false') {
          textWrapFadeUp(fadeWrap)
        }
      })

      $('.text-fade-down').each(function (indexInArray, fadeWrap) {
        var isFaded = $(fadeWrap).attr('data-is-faded')

        if (isInViewport(fadeWrap) && isFaded == 'false') {
          textWrapFadeDown(fadeWrap)
        }
      })

      $('.text-fade-left').each(function (indexInArray, fadeWrap) {
        var isFaded = $(fadeWrap).attr('data-is-faded')

        if (isInViewport(fadeWrap) && isFaded == 'false') {
          textWrapFadeLeft(fadeWrap)
        }
      })

      // Animejs fade its rotate run
      $('.it-fade-rotate').each(function (indexInArray, fadeWrap) {
        var isFaded = $(fadeWrap).attr('data-is-faded')

        if (isInViewport(fadeWrap) && isFaded == 'false') {
          textFadeRote(fadeWrap)
        }
      })
    })
  })
}

runAnimationFade()

//
function imgWrapFadeRight(fadeWrap) {
  jQuery(document).ready(function ($) {
    $(fadeWrap).css({ opacity: 1 })
    $(fadeWrap).attr('data-is-faded', 'true')

    var fadeChild = fadeWrap.querySelectorAll('.img-fade-child')

    var timeline = anime.timeline()

    timeline.add({
      targets: fadeChild,
      delay: (el, i) => 100 * (i + 1),
      translateX: { value: [200, 0], duration: 800 },
      opacity: { value: [0, 1], duration: 700 },
      loop: false,
    })
  })
}

function textWrapFadeLeft(fadeWrap) {
  jQuery(document).ready(function ($) {
    $(fadeWrap).css({ opacity: 1 })
    $(fadeWrap).attr('data-is-faded', 'true')

    var timeline = anime.timeline()

    var childLetter = fadeWrap.querySelectorAll('.letter')
    var fadeChild = fadeWrap.querySelectorAll('.child')

    timeline.add({
      targets: childLetter,
      duration: 320,
      delay: (el, i) => 30 * (i + 1),
      easing: 'easeInOutQuad',
      opacity: [0, 1],
    })

    timeline.add({
      targets: fadeChild,
      duration: 500,
      delay: (el, i) => 60 * (i + 1),
      easing: 'easeInOutQuad',
      opacity: [0, 1],
      translateY: [25, 0],
    })
  })
}

function textWrapFadeUp(fadeWrap) {
  jQuery(document).ready(function ($) {
    $(fadeWrap).css({ opacity: 1 })

    $(fadeWrap).attr('data-is-faded', 'true')

    var fadeChild = fadeWrap.querySelectorAll('.child')

    var timeline = anime.timeline()

    timeline.add({
      targets: fadeChild,
      duration: 600,
      delay: (el, i) => 70 * (i + 1),
      easing: 'easeInOutQuad',
      opacity: [0, 1],
      translateY: [25, 0],
    })
  })
}

function textWrapFadeDown(fadeWrap) {
  jQuery(document).ready(function ($) {
    $(fadeWrap).css({ opacity: 1 })
    $(fadeWrap).attr('data-is-faded', 'true')

    var fadeChild = fadeWrap.querySelectorAll('.child')

    var timeline = anime.timeline()

    timeline.add({
      targets: fadeChild,
      duration: 600,
      delay: (el, i) => 70 * (i + 1),
      easing: 'easeInOutQuad',
      opacity: [0, 1],
      translateY: [-25, 0],
    })
  })
}

function textFadeRote(fadeWrap) {
  jQuery(document).ready(function ($) {
    $(fadeWrap).attr('data-is-faded', 'true')

    var fadeChild = fadeWrap.querySelectorAll('.child')

    var timeline = anime.timeline()

    timeline.add({
      targets: fadeChild,
      duration: 500,
      delay: (el, i) => 60 * (i + 1),
      easing: 'easeInOutQuad',
      rotate: [80, 0],
      opacity: 1,
      translateX: [100, 0],
      translateY: [-200, 0],
    })
  })
}

// Script item parralax on mouse move
function parralaxOnMouse() {
  jQuery(document).ready(function ($) {
    $('.sect-move-paralax').each(function (indexInArray, sectionElement) {
      //
      $(sectionElement).mousemove(function (event) {
        $(sectionElement)
          .find('.parralax-left')
          .each(function (indexInArray, colElement) {
            $(colElement).css({
              transform: `translate(-${event.clientX / 100}%, -${
                event.clientY / 50
              }%)`,
            })
          })
        $(sectionElement)
          .find('.parralax-right')
          .each(function (indexInArray, colElement) {
            $(colElement).css({
              transform: `translate(${event.clientX / 150}%, ${
                event.clientY / 170
              }%)`,
            })
          })
      })
    })
  })
}

parralaxOnMouse()
