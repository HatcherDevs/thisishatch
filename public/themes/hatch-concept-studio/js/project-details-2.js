(function () {
  function initProjectVideo() {
    const cursor = document.querySelector('.cursor');
    const playLabel = cursor
      ? cursor.querySelector('#playBtn')
      : null;

    const videoWrap = document.getElementById('pd2VideoCustom');
    const media = document.getElementById('pd2Video');
    const staticBtn = document.getElementById('pd2PlayBtn');
    let cover = document.getElementById('pd2VideoCover');

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

    // iframes swallow pointer events, so a transparent layer must always sit
    // above them; create one when the template rendered no cover element.
    if (isIframe && !cover) {
      cover = document.createElement('div');
      cover.className =
        'pd2-video-cover pd2-video-cover--transparent pd2-video-cover--interactive';
      cover.id = 'pd2VideoCover';
      videoWrap.appendChild(cover);
    }

    let isPlaying = false;
    let iframeHasStarted = false;

    // iframe players must be driven through postMessage: rewriting the src to
    // pause reloads the player and restarts playback from 00:00.
    function sendPlayerCommand(command) {
      if (!media.contentWindow) {
        return;
      }

      const source = (media.getAttribute('src') || '').toLowerCase();
      let payload = null;

      if (source.indexOf('youtube.com') !== -1 || source.indexOf('youtu.be') !== -1) {
        payload = JSON.stringify({
          event: 'command',
          func: command === 'play' ? 'playVideo' : 'pauseVideo',
          args: '',
        });
      } else if (source.indexOf('vimeo.com') !== -1) {
        payload = JSON.stringify({ method: command });
      }

      if (payload) {
        media.contentWindow.postMessage(payload, '*');
      }
    }

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
      if (!cover) {
        return;
      }

      // while an iframe plays, keep a transparent layer above it so pointer
      // events stay in this document (iframes swallow mouse events).
      if (isIframe) {
        cover.classList.add('pd2-video-cover--interactive');
        cover.classList.remove('is-hidden');

        return;
      }

      cover.classList.remove('pd2-video-cover--interactive');
      cover.classList.add('is-hidden');
    }

    function showCover() {
      if (!cover) {
        return;
      }

      cover.classList.remove('pd2-video-cover--interactive');
      cover.classList.remove('is-hidden');
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

        if (iframeHasStarted) {
          sendPlayerCommand('play');
        } else {
          iframeHasStarted = true;

          if (!currentSrc.includes('autoplay=1')) {
            const separator = currentSrc.includes('?')
              ? '&'
              : '?';

            media.setAttribute(
              'src',
              currentSrc + separator + 'autoplay=1'
            );
          }
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
        iframeHasStarted = true;
        sendPlayerCommand('pause');
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
      let pointerInsideVideo = false;

      const isPointerOverVideo = function (clientX, clientY) {
        const rect = videoWrap.getBoundingClientRect();

        return (
          clientX >= rect.left &&
          clientX <= rect.right &&
          clientY >= rect.top &&
          clientY <= rect.bottom
        );
      };

      // Tracked at document level (capture phase) because iframes reload,
      // spurious mouseleave events and event swallowing all break
      // element-level hover tracking.
      const syncVideoCursor = function (clientX, clientY) {
        const isInside = isPointerOverVideo(clientX, clientY);

        // Own the cursor position here so the circle keeps following the
        // pointer even while an iframe is playing (its own copy of the
        // document can swallow the movement events).
        cursor.style.left = clientX + 'px';
        cursor.style.top = clientY + 'px';

        if (isInside) {
          pointerInsideVideo = true;
          setVideoCursor(true);

          return;
        }

        if (!pointerInsideVideo) {
          return;
        }

        pointerInsideVideo = false;
        setVideoCursor(false);
      };

      document.addEventListener(
        'mousemove',
        function (event) {
          syncVideoCursor(event.clientX, event.clientY);
        },
        true
      );

      videoWrap.addEventListener('mouseleave', function (event) {
        if (event.clientX === 0 && event.clientY === 0) {
          return;
        }

        syncVideoCursor(event.clientX, event.clientY);
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

// Initialize each project-video shortcode independently.
(function () {
  function initShortcodeVideos() {
    document.querySelectorAll('.pd2-video-custom[id^="projectVideo-"]').forEach(function (videoWrap) {
      if (videoWrap.dataset.shortcodeInitialized === 'true') {
        return;
      }

      const media = videoWrap.querySelector('video, iframe');
      let cover = videoWrap.querySelector('.pd2-video-cover');
      const button = videoWrap.querySelector('.pd2-play-btn');
      const cursor = document.querySelector('.cursor');
      const cursorLabel = cursor ? cursor.querySelector('#playBtn') : null;

      if (!media) {
        return;
      }

      videoWrap.dataset.shortcodeInitialized = 'true';
      let isPlaying = false;
      let hideTimer = null;
      let lastToggleAt = 0;
      let stopRequestedUntil = 0;
      let iframeHasStarted = false;

      const mediaType = media.tagName.toLowerCase();
      const mediaIsIframe = mediaType === 'iframe';

      // iframe players must be driven through postMessage: rewriting the src to
      // pause reloads the player and restarts playback from 00:00.
      function sendPlayerCommand(command) {
        if (!media.contentWindow) {
          return;
        }

        const source = (media.getAttribute('src') || '').toLowerCase();
        let payload = null;

        if (source.indexOf('youtube.com') !== -1 || source.indexOf('youtu.be') !== -1) {
          payload = JSON.stringify({
            event: 'command',
            func: command === 'play' ? 'playVideo' : 'pauseVideo',
            args: '',
          });
        } else if (source.indexOf('vimeo.com') !== -1) {
          payload = JSON.stringify({ method: command });
        }

        if (payload) {
          media.contentWindow.postMessage(payload, '*');
        }
      }

      // iframes swallow pointer events, so a transparent layer must always sit
      // above them; create one when the template rendered no cover element.
      if (mediaIsIframe && !cover) {
        cover = document.createElement('div');
        cover.className =
          'pd2-video-cover pd2-video-cover--transparent pd2-video-cover--interactive';
        cover.id = videoWrap.id + '-overlay';
        videoWrap.appendChild(cover);
      }

      function setCoverHidden(hidden) {
        if (!cover) {
          return;
        }

        // while an iframe plays, keep a transparent layer above it so pointer
        // events stay in this document (iframes swallow mouse events).
        if (hidden && mediaIsIframe) {
          cover.classList.add('pd2-video-cover--interactive');
          cover.classList.remove('is-hidden');

          return;
        }

        cover.classList.remove('pd2-video-cover--interactive');
        cover.classList.toggle('is-hidden', hidden);
      }

      function showButton() {
        videoWrap.classList.remove('is-controls-hidden');
      }

      function hideButton() {
        if (isPlaying) {
          videoWrap.classList.add('is-controls-hidden');
        }
      }

      function scheduleButtonHide() {
        if (hideTimer) {
          window.clearTimeout(hideTimer);
        }

        if (isPlaying) {
          hideTimer = window.setTimeout(hideButton, 2000);
        }
      }

      function setState(playing) {
        isPlaying = playing;

        if (button) {
          button.textContent = playing ? 'Stop' : 'Play';
          button.setAttribute('aria-label', playing ? 'Stop video' : 'Play video');
        }

        if (cursorLabel) {
          cursorLabel.textContent = playing ? 'Stop' : 'Play';
        }

        if (!playing) {
          if (hideTimer) {
            window.clearTimeout(hideTimer);
          }

          showButton();
        }
      }

      function play() {
        stopRequestedUntil = 0;

        if (media.tagName.toLowerCase() === 'video') {
          media.play().catch(function (error) {
            console.warn('Video playback failed:', error);
          });
        } else if (iframeHasStarted) {
          sendPlayerCommand('play');
        } else {
          iframeHasStarted = true;

          const source = media.getAttribute('src');

          if (source && !source.includes('autoplay=1')) {
            media.setAttribute('src', source + (source.includes('?') ? '&' : '?') + 'autoplay=1');
          }
        }

        setCoverHidden(true);
        setState(true);
      }

      function pause() {
        stopRequestedUntil = Date.now() + 500;

        if (media.tagName.toLowerCase() === 'video') {
          media.pause();
        } else {
          iframeHasStarted = true;
          sendPlayerCommand('pause');
        }

        setCoverHidden(false);
        setState(false);
      }

      function togglePlayback() {
        const now = Date.now();

        if (now - lastToggleAt < 350) {
          return;
        }

        lastToggleAt = now;

        if (isPlaying) {
          pause();
        } else {
          play();
        }
      }

      if (button) {
        button.addEventListener('click', function (event) {
          event.preventDefault();
          event.stopPropagation();
          event.stopImmediatePropagation();
          togglePlayback();
        });
      }

      if (cover) {
        cover.addEventListener('click', function (event) {
          if (button && event.target === button) {
            return;
          }

          event.preventDefault();
          event.stopPropagation();
          togglePlayback();
        });
      }

      if (media.tagName.toLowerCase() === 'video') {
        media.addEventListener('play', function () {
          if (Date.now() < stopRequestedUntil) {
            media.pause();
            return;
          }

          setCoverHidden(true);
          setState(true);
        });
        media.addEventListener('pause', function () {
          setCoverHidden(false);
          setState(false);
        });
        media.addEventListener('ended', function () {
          setCoverHidden(false);
          setState(false);
        });
      }

      let pointerInsideVideo = false;

      const isPointerOverVideo = function (clientX, clientY) {
        const rect = videoWrap.getBoundingClientRect();

        return (
          clientX >= rect.left &&
          clientX <= rect.right &&
          clientY >= rect.top &&
          clientY <= rect.bottom
        );
      };

      const syncCursorState = function (clientX, clientY) {
        if (!cursor) {
          return;
        }

        const isInside = isPointerOverVideo(clientX, clientY);

        // Own the cursor position here so the circle keeps following the
        // pointer even while an iframe is playing (its own copy of the
        // document can swallow the movement events).
        cursor.style.left = clientX + 'px';
        cursor.style.top = clientY + 'px';

        if (isInside) {
          pointerInsideVideo = true;
          videoWrap.classList.add('is-cursor-active');
          cursor.classList.add('is-video-play');
          cursor.style.transform = 'translate(-50%, -50%)';
          showButton();
          scheduleButtonHide();

          return;
        }

        if (!pointerInsideVideo) {
          return;
        }

        pointerInsideVideo = false;

        if (hideTimer) {
          window.clearTimeout(hideTimer);
        }

        hideButton();

        cursor.classList.remove('is-video-play');
        cursor.style.transform = '';
        videoWrap.classList.remove('is-cursor-active');
      };

      // Tracked at document level (capture phase) because iframe reloads,
      // spurious mouseleave events and event swallowing all break
      // element-level hover tracking.
      document.addEventListener(
        'mousemove',
        function (event) {
          syncCursorState(event.clientX, event.clientY);
        },
        true
      );

      videoWrap.addEventListener('mouseleave', function (event) {
        if (event.clientX === 0 && event.clientY === 0) {
          return;
        }

        syncCursorState(event.clientX, event.clientY);
      });

      videoWrap.addEventListener('click', function (event) {
        if (event.target.closest('.pd2-play-btn, .pd2-video-cover')) {
          return;
        }

        togglePlayback();
      });

      setState(false);
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initShortcodeVideos);
  } else {
    initShortcodeVideos();
  }

  window.addEventListener('load', initShortcodeVideos);
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

