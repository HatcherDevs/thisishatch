(function () {
  const cursor = document.querySelector('.cursor');
  const playLabel = cursor?.querySelector('#playBtn');
  const videoWrap = document.getElementById('pd2VideoCustom');
  const video = document.getElementById('pd2Video');
  const staticBtn = document.getElementById('pd2PlayBtn');

  if (!cursor || !videoWrap || !video) {
    return;
  }

  function syncPlayLabel() {
    const label = video.paused ? 'Play' : 'Stop';
    if (playLabel) {
      playLabel.textContent = label;
    }
    if (staticBtn) {
      staticBtn.textContent = label;
    }
  }

  function setVideoCursor(active) {
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

  function toggleVideo() {
    if (video.paused) {
      video.play();
    } else {
      video.pause();
    }
    syncPlayLabel();
  }

  videoWrap.addEventListener('mouseenter', function () {
    setVideoCursor(true);
  });

  videoWrap.addEventListener('mouseleave', function () {
    setVideoCursor(false);
  });

  videoWrap.addEventListener('click', toggleVideo);

  video.addEventListener('play', syncPlayLabel);
  video.addEventListener('pause', syncPlayLabel);
  video.addEventListener('ended', syncPlayLabel);

  syncPlayLabel();
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