(function () {
  function initProjectVideo() {
    const cursor = document.querySelector('.cursor');
    const playLabel = cursor
      ? cursor.querySelector('#playBtn')
      : null;

    const videoWrap = document.getElementById('pd2VideoCustom');
    const media = document.getElementById('pd2Video');
    const staticBtn = document.getElementById('pd2PlayBtn');
    const cover = document.getElementById('pd2VideoCover');

    if (!videoWrap || !media) {
      return;
    }

    if (videoWrap.dataset.initialized === 'true') {
      return;
    }

    videoWrap.dataset.initialized = 'true';

    const mediaType = media.tagName.toLowerCase();
    const isHtmlVideo = mediaType === 'video';
    const isIframe = mediaType === 'iframe';

    let isPlaying = false;

    function setLabel(label) {
      if (playLabel) {
        playLabel.textContent = label;
      }

      if (staticBtn) {
        staticBtn.textContent = label;
      }
    }

    function showPlayState() {
      isPlaying = false;
      setLabel('Play');
    }

    function showStopState() {
      isPlaying = true;
      setLabel('Stop');
    }

    function hideCover() {
      if (cover) {
        cover.classList.add('is-hidden');
      }
    }

    function showCover() {
      if (cover) {
        cover.classList.remove('is-hidden');
      }
    }

    function playMedia() {
      if (isHtmlVideo) {
        media.play().catch(function (error) {
          console.warn('Video playback failed:', error);
        });

        showStopState();
        hideCover();

        return;
      }

      if (isIframe) {
        const currentSrc = media.getAttribute('src');

        if (!currentSrc) {
          return;
        }

        if (!currentSrc.includes('autoplay=1')) {
          const separator = currentSrc.includes('?')
            ? '&'
            : '?';

          media.setAttribute(
            'src',
            currentSrc + separator + 'autoplay=1'
          );
        }

        media.dataset.playing = 'true';

        showStopState();
        hideCover();
      }
    }

    function pauseMedia() {
      if (isHtmlVideo) {
        media.pause();
        showPlayState();
        return;
      }

      if (isIframe) {
        const currentSrc = media.getAttribute('src');

        if (currentSrc) {
          const cleanSrc = currentSrc
            .replace('&autoplay=1', '')
            .replace('?autoplay=1', '');

          media.setAttribute('src', cleanSrc);
        }

        media.dataset.playing = 'false';

        showPlayState();
        showCover();
      }
    }

    function toggleMedia(event) {
      if (event) {
        event.preventDefault();
        event.stopPropagation();
      }

      if (isPlaying) {
        pauseMedia();
      } else {
        playMedia();
      }
    }

    function syncPlayLabel() {
      if (isHtmlVideo) {
        if (media.paused) {
          showPlayState();
        } else {
          showStopState();
        }

        return;
      }

      // iframe لا يحتوي على paused مثل video
      setLabel(isPlaying ? 'Stop' : 'Play');
    }

    function setVideoCursor(active) {
      if (!cursor) {
        return;
      }

      if (active) {
        videoWrap.classList.add('is-hovering');
        cursor.classList.add('is-video-play');
        cursor.style.transform = 'translate(-50%, -50%)';
      } else {
        videoWrap.classList.remove('is-hovering');
        cursor.classList.remove('is-video-play');
        cursor.style.transform = '';
      }

      syncPlayLabel();
    }
    function showCursorPlayLabel() {
      if (playLabel) {
        playLabel.style.display = 'block';
        playLabel.textContent = 'Play';
      }
    }

    function hideCursorPlayLabel() {
      if (playLabel) {
        playLabel.style.display = 'none';
      }
    }
    // الحالة الابتدائية دائمًا Play
    showPlayState();
    showCover();

    if (cursor) {
      videoWrap.addEventListener('mouseenter', function () {
        setVideoCursor(true);
      });

      videoWrap.addEventListener('mouseleave', function () {
        setVideoCursor(false);
      });
    }

    // الضغط على منطقة الفيديو
    videoWrap.addEventListener('click', function (event) {
      if (
        event.target.closest('#pd2PlayBtn') ||
        event.target.closest('.pd2-video-cover')
      ) {
        return;
      }

      // لا تستخدم toggle مع iframe عند الضغط بعد إخفاء الغلاف
      if (isHtmlVideo) {
        toggleMedia(event);
      }
    });

    // الضغط على زر Play داخل الدائرة
    if (staticBtn) {
      staticBtn.addEventListener('click', function (event) {
        toggleMedia(event);
      });
    }

    // الضغط على غلاف الفيديو
    if (cover) {
      cover.addEventListener('click', function (event) {
        toggleMedia(event);
      });
    }

    if (isHtmlVideo) {
      media.addEventListener('play', function () {
        showStopState();
        hideCover();
      });

      media.addEventListener('pause', function () {
        showPlayState();
      });

      media.addEventListener('ended', function () {
        showPlayState();
        showCover();
      });
    }

    syncPlayLabel();
  }

  if (document.readyState === 'loading') {
    document.addEventListener(
      'DOMContentLoaded',
      initProjectVideo
    );
  } else {
    initProjectVideo();
  }

  window.addEventListener('load', initProjectVideo);
})();



(function () {
  const swiperEl = document.querySelector('.pd2-swiper');
  if (!swiperEl || typeof Swiper === 'undefined') {
    return;
  }

  new Swiper('.pd2-swiper', {
    slidesPerView: 3,
    spaceBetween: 22,
    speed: 600,
    grabCursor: true,
    breakpoints: {
      1024: {
        slidesPerView: 3,
        spaceBetween: 22,
      },
      768: {
        slidesPerView: 2,
        spaceBetween: 22,
      },
      640: {
        slidesPerView: 1.4,
        spaceBetween: 22,
      },
      320: {
        slidesPerView: 1.1,
        spaceBetween: 22,
      },
    },
    navigation: {
      nextEl: '.pd2-swiper-next',
      prevEl: '.pd2-swiper-prev',
    },
  });
})();

window.addEventListener('load', function () {
  if (typeof initPd2ScrollEffects === 'function') {
    initPd2ScrollEffects();
  }
});


document.addEventListener('DOMContentLoaded', function () {
  document
    .querySelectorAll('.pd2-project-nav button[data-url]')
    .forEach(function (button) {
      button.addEventListener('click', function () {
        const url = button.getAttribute('data-url');

        if (url) {
          window.location.href = url;
        }
      });
    });
});

