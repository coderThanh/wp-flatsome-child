// ... existing code ...
document.addEventListener('DOMContentLoaded', function () {
  const videos = document.querySelectorAll('.video-on-view video')
  let userInteracted = false

  // Xác định thiết bị mobile/tablet
  function isMobileOrTablet() {
    return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(
      navigator.userAgent,
    )
  }

  function onUserInteract() {
    userInteracted = true
    videos.forEach((video) => {
      if (video.dataset.inview === 'true') {
        video.muted = false
      }
    })
    window.removeEventListener('click', onUserInteract)
    window.removeEventListener('keydown', onUserInteract)
  }

  function onClickVideo(event) {
    const video = event.currentTarget

    if (!isMobileOrTablet()) {
      return
    }
    video.muted = false

    if (video.paused) {
      video.play()
    }
  }

  window.addEventListener('click', onUserInteract)
  window.addEventListener('keydown', onUserInteract)

  if (!('IntersectionObserver' in window)) {
    videos.forEach((video) => {
      video.muted = true
      video.play()
    })
    return
  }

  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        const video = entry.target

        // Nếu là mobile/tablet và đã autoplay rồi thì không tự động play nữa
        if (isMobileOrTablet()) {
          return
        }

        // Desktop: luôn play khi vào view
        if (entry.isIntersecting) {
          video.dataset.inview = 'true'

          if (userInteracted) {
            video.muted = false
          } else {
            video.muted = true
          }
          video.play()
        } else {
          video.dataset.inview = 'false'
          video.pause()
        }
      })
    },
    {
      threshold: 0.3,
    },
  )

  videos.forEach((video) => {
    observer.observe(video)
    video.addEventListener('click', onClickVideo)
  })
})
