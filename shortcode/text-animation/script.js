// Khởi tạo text animation cho tất cả elements
document.addEventListener('DOMContentLoaded', function () {
  const textElements = document.querySelectorAll('.pt-text-animate')

  textElements.forEach(function (textEl) {
    initTextAnimation(textEl)
  })
})

function initTextAnimation(textEl) {
  // Lấy dữ liệu từ data attributes
  const textsData = textEl.getAttribute('data-texts')

  // Parse timing values với try-catch để xử lý lỗi
  let milisecondChange = 2000
  let milisecondAnimationIn = 2000
  let milisecondAnimationOut = 2000

  try {
    const changeValue = textEl.getAttribute('data-milisecond-change')
    if (changeValue) {
      const parsed = parseInt(changeValue)
      if (!isNaN(parsed) && parsed > 0) {
        milisecondChange = parsed
      }
    }
  } catch (e) {
    console.warn('Invalid data-milisecond-change value, using default 2000ms')
  }

  try {
    const animationInValue = textEl.getAttribute('data-milisecond-animation-in')
    if (animationInValue) {
      const parsed = parseInt(animationInValue)
      if (!isNaN(parsed) && parsed > 0) {
        milisecondAnimationIn = parsed
      }
    }
  } catch (e) {
    console.warn(
      'Invalid data-milisecond-animation-in value, using default 2000ms',
    )
  }

  try {
    const animationOutValue = textEl.getAttribute(
      'data-milisecond-animation-out',
    )
    if (animationOutValue) {
      const parsed = parseInt(animationOutValue)
      if (!isNaN(parsed) && parsed > 0) {
        milisecondAnimationOut = parsed
      }
    }
  } catch (e) {
    console.warn(
      'Invalid data-milisecond-animation-out value, using default 2000ms',
    )
  }

  // Parse texts array từ string
  let texts = []
  if (textsData) {
    try {
      // Xử lý trường hợp data-texts có thể là JSON hoặc comma-separated
      if (textsData.startsWith('[') && textsData.endsWith(']')) {
        texts = JSON.parse(textsData)
      } else if (textsData.startsWith('{') && textsData.endsWith('}')) {
        // Handle object-like JSON: extract values and convert to array
        const obj = JSON.parse(textsData)
        texts = Object.values(obj)
      } else {
        texts = textsData.split(',').map((text) => text.trim())
      }
    } catch (e) {
      // Fallback: split by comma
      texts = textsData.split(',').map((text) => text.trim())
    }
  }

  if (texts.length === 0) {
    console.warn('No texts found for text animation')
    return
  }

  let currentIndex = 0

  function wrapLetters(text) {
    textEl.innerHTML = text
      .split('')
      .map(
        (ch) =>
          `<span style="opacity: 0;transform-origin: center;display: inline-block;${ch === ' ' ? 'width: 0.2em;' : ''}" class="letter">${ch === ' ' ? '&nbsp;' : ch}</span>`,
      )
      .join('')
  }

  function animateText() {
    const letters = textEl.querySelectorAll('.letter')

    // Fade in: từ rotate & translate ngẫu nhiên -> 0
    anime({
      targets: letters,
      opacity: [0, 1],
      rotate: () => [anime.random(-90, 90), 0],
      translateY: () => [anime.random(-40, -80), 0],
      duration: milisecondAnimationIn,
      delay: anime.stagger(50),
      easing: 'easeOutExpo',
      complete: () => {
        setTimeout(() => fadeOutText(), milisecondChange)
      },
    })
  }

  function fadeOutText() {
    const letters = textEl.querySelectorAll('.letter')

    // Fade out: từ 0 -> rotate & translate ngẫu nhiên
    anime({
      targets: letters,
      opacity: [1, 0],
      rotate: () => [0, anime.random(-90, 90)],
      translateY: () => [0, anime.random(-60, -100)],
      duration: milisecondAnimationOut,
      delay: anime.stagger(30),
      easing: 'easeInExpo',
      complete: () => {
        currentIndex = (currentIndex + 1) % texts.length
        showNextText()
      },
    })
  }

  function showNextText() {
    wrapLetters(texts[currentIndex])
    animateText()
  }

  // Khởi chạy animation cho element này
  showNextText()
}
