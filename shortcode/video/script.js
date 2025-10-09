(function () {
  function setState(container, isPlaying) {
    if (!container) return;
    if (isPlaying) {
      container.classList.add('is-playing');
      container.classList.remove('is-paused');
    } else {
      container.classList.add('is-paused');
      container.classList.remove('is-playing');
    }
  }

  function setMuteClass(container, isMuted) {
    if (!container) return;
    if (isMuted) {
      container.classList.add('is-muted');
      container.classList.remove('is-unmuted');
    } else {
      container.classList.remove('is-muted');
      container.classList.add('is-unmuted');
    }
  }

  // Toggle play/pause by video id, used by buttons in HTML
  window.togglePlayPause = function (videoId, shouldPlay) {
    var video = document.getElementById(videoId);
    if (!video) return;
    var container = video.closest('.pt-video');

    if (shouldPlay) {
      var playPromise = video.play();
      if (playPromise && typeof playPromise.then === 'function') {
        playPromise
          .then(function () {
            setState(container, true);
          })
          .catch(function () {
            // Autoplay or play could be blocked
            setState(container, false);
          });
      } else {
        setState(container, true);
      }
    } else {
      video.pause();
      setState(container, false);
    }
  };

  // Toggle mute by video id, optional for future mute buttons
  window.toggleMute = function (videoId, shouldMute) {
    var video = document.getElementById(videoId);
    if (!video) return;
    var container = video.closest('.pt-video');
    video.muted = !!shouldMute;
    setMuteClass(container, !!video.muted);
  };

  function initVideo(container) {
    var video = container.querySelector('video.el-video');
    if (!video) return;

    // Set initial state based on video status
    setState(container, !video.paused && !video.ended);
    setMuteClass(container, !!video.muted);

    // Keep state in sync with actual video events
    video.addEventListener('play', function () {
      setState(container, true);
    });
    video.addEventListener('pause', function () {
      setState(container, false);
    });
    video.addEventListener('ended', function () {
      setState(container, false);
    });


    // Hover autoplay support via data-hover-autoplay="true"
    var hoverAutoplay = video.getAttribute('data-hover-autoplay') === 'true';
    if (hoverAutoplay) {
      container.addEventListener('mouseenter', function () {
        var p = video.play();
        if (p && typeof p.catch === 'function') {
          p.catch(function () {
            setState(container, false);
          });
        }
      });

      container.addEventListener('mouseleave', function () {
        video.pause();
      });
    }
  }

  document.addEventListener('DOMContentLoaded', function () {
    var containers = document.querySelectorAll('.pt-video');
    containers.forEach(initVideo);
  });
})();