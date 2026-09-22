// Add a check for mobile devices
const isMobile = window.innerWidth <= 767; // You can adjust this breakpoint based on your design


function locomotive() {
  gsap.registerPlugin(ScrollTrigger);

  const locoScroll = new LocomotiveScroll({
    el: document.querySelector("#main"),
    smooth: true,
    scrollFromAnywhere: true,
  });
  locoScroll.on("scroll", ScrollTrigger.update);

  ScrollTrigger.scrollerProxy("#main", {
    scrollTop(value) {
      return arguments.length
        ? locoScroll.scrollTo(value, 0, 0)
        : locoScroll.scroll.instance.scroll.y;
    },

    getBoundingClientRect() {
      return {
        top: 0,
        left: 0,
        width: window.innerWidth,
        height: window.innerHeight,
      };
    },

    pinType: document.querySelector("#main").style.transform
      ? "transform"
      : "fixed",
  });
  ScrollTrigger.addEventListener("refresh", () => locoScroll.update());
  ScrollTrigger.refresh();
}
locomotive();


const canvas = document.querySelector("canvas");
const context = canvas.getContext("2d");

canvas.width = window.innerWidth;
canvas.height = window.innerHeight;


window.addEventListener("resize", function () {
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;
  render();
});

function files(index) {
  const n = String(index).padStart(4, '0');
  return `/themes/hatch-concept-studio/imgs/horse-webp/turn02_${n}.webp`;
}

const frameCount = 300;

const images = [];
const imageSeq = {
  frame: 1,
};

for (let i = 0; i < frameCount; i++) {
  const img = new Image();
  img.src = files(i);
  images.push(img);
}


gsap.to(imageSeq, {
  frame: frameCount - 1,
  snap: "frame",
  ease: `none`,
  scrollTrigger: {
    scrub: 0.15,
    trigger: `#horse-scroll-spacer`,
    start: `top top`,
    end: `bottom top`,
    scroller: `#main`,
  },
  onUpdate: render,
});

images[1].onload = render;

function render() {
  scaleImage(images[imageSeq.frame], context);
}

function scaleImage(img, ctx) {
  var canvas = ctx.canvas;
  var hRatio = canvas.width / img.width;
  var vRatio = canvas.height / img.height;
  var ratio = Math.max(hRatio, vRatio);

  // Adjust the ratio for mobile devices
  ratio *= 0.8;
  if (isMobile) {
    ratio *= 1; // You can adjust this scaling factor based on your design
  }

  var centerShift_x = (canvas.width - img.width * ratio) / 2;

  // Position the image at the top of the canvas
  var centerShift_y = 0;

  ctx.clearRect(0, 0, canvas.width, canvas.height);
  ctx.drawImage(
    img,
    0,
    0,
    img.width,
    img.height,
    centerShift_x,
    centerShift_y,
    img.width * ratio,
    img.height * ratio
  );
}



ScrollTrigger.create({
  trigger: "#horse-scroll-spacer",
  start: "top top",
  end: "bottom top",
  scroller: `#main`,
  onUpdate: (self) => {
    const horseActive = self.progress < 1;
    gsap.set(".click_graphics", {
      opacity: horseActive ? 1 : 0,
      pointerEvents: horseActive ? "auto" : "none",
    });
  },
});

gsap.set(".layout", { bottom: "100%", opacity: 1 });
gsap.to(".layout", {
  bottom: 0,
  opacity: 1,
  ease: "power2.inOut", // يمكنك تغيير هذا حسب التفضيلات
  duration: 2, // يمكنك ضبط مدة التأثير
  delay: 1, // يمكنك ضبط تأخير بداية التأثير
});

gsap.to("#page", {
  opacity: 1,
  ease: "power2.inOut", // يمكنك تغيير هذا حسب التفضيلات
  duration: 2, // يمكنك ضبط مدة التأثير
  delay: 2, // يمكنك ضبط تأخير بداية التأثير
});
gsap.to("#nav", {
  opacity: 1,
  ease: "power2.inOut", // يمكنك تغيير هذا حسب التفضيلات
  duration: 2, // يمكنك ضبط مدة التأثير
  delay: 1.5, // يمكنك ضبط تأخير بداية التأثير
});
gsap.to(".click_graphics", {
  opacity: 1,
  ease: "power2.inOut",
  duration: 2,
  delay: 1.5,
});
gsap.to(".layout", {
  opacity: 0,
  display: 'none',
  ease: "power2.inOut", // يمكنك تغيير هذا حسب التفضيلات
  duration: 2, // يمكنك ضبط مدة التأثير
  delay: 2, // يمكنك ضبط تأخير بداية التأثير
});

// ------------------------------------ For Icons on Header -------------------------

document.addEventListener('DOMContentLoaded', function () {
  const elements = document.querySelectorAll('.click_graphics');

  elements.forEach(element => {
    element.addEventListener('click', function () {
      // إضافة تأثير الاهتزاز
      element.classList.add('shake');

      // إضافة تأثير التوهج
      setTimeout(() => {
        element.classList.remove('shake');
        element.classList.add('glow');

        // إزالة التأثيرات بعد 1 ثانية
        setTimeout(() => {
          element.classList.remove('shake', 'glow');
        }, 10);
      }, 500);
    });
  });
});
// --------------------------------- For Mose Move ------------------------------
(function () {
  const links = document.querySelectorAll('a');
  const cursor = document.querySelector('.cursor');

  const editCursor = e => {
    const { clientX: x, clientY: y } = e;
    cursor.style.left = x + 'px';
    cursor.style.top = y + 'px';
  };

  links.forEach(link => {
    if (link.closest('.video-custom')) {
      return;
    }

    link.addEventListener('mouseenter', () => {
      if (!cursor.classList.contains('is-video-play')) {
        cursor.style.transform = 'translate(-50%, -50%) scale(4)';
      }
    });

    link.addEventListener('mouseleave', () => {
      if (!cursor.classList.contains('is-video-play')) {
        cursor.style.transform = 'translate(-50%, -50%) scale(1)';
      }
    });
  });

  document.addEventListener('mousemove', editCursor);
  var spanV = cursor.querySelector('#playBtn');
  var videoCustom = document.querySelector('.video-custom');
  var playButton = document.getElementById('play_button');

  function syncPlayLabel() {
    const isPlaying = document.documentElement.classList.contains('playvideo');
    const label = isPlaying ? 'Stop' : 'Play';
    const playSpan = playButton?.querySelector('span');
    if (playSpan) {
      playSpan.textContent = label;
    }
    if (spanV) {
      spanV.textContent = label;
    }
  }

  function setVideoCursor(active) {
    if (!videoCustom) {
      return;
    }

    if (active) {
      videoCustom.classList.add('is-hovering');
      cursor.classList.add('is-video-play');
      cursor.style.transform = 'translate(-50%, -50%)';
      syncPlayLabel();
    } else {
      videoCustom.classList.remove('is-hovering');
      cursor.classList.remove('is-video-play');
      cursor.style.transform = 'translate(-50%, -50%) scale(1)';
    }
  }

  if (videoCustom) {
    videoCustom.addEventListener('mouseenter', function () {
      setVideoCursor(true);
    });

    videoCustom.addEventListener('mouseleave', function () {
      setVideoCursor(false);
    });

    videoCustom.addEventListener('click', function () {
      if (playButton) {
        playButton.click();
      }
    });
  }



  //   const page3 = document.querySelector('#page3');

  // page3.addEventListener('mouseenter', () => {
  //   cursor.style.display='none';
  // });
  // page3.addEventListener('mouseleave', () => {
  //   cursor.style.display='flex';
  // });

})();



//Video Play Pause Control Start
let playButton = document.getElementById("play_button");
let playBtnBlue = document.getElementById("playBtn");
let pauseButton = document.getElementById("pause_button");
playButton.addEventListener("click", function (e) {
  e.stopPropagation();
  const playSpan = playButton.querySelector('span');

  if (document.documentElement.classList.contains('playvideo')) {
    video.pause();
    document.querySelector('html').classList.remove('playvideo');
    if (playSpan) playSpan.textContent = 'Play';
    playBtnBlue.textContent = 'Play';
    return;
  }

  video.play();
  document.querySelector('html').classList.add('playvideo');
  if (playSpan) playSpan.textContent = 'Stop';
  playBtnBlue.textContent = 'Stop';
});

pauseButton.addEventListener("click", function (e) {
  e.stopPropagation();
  video.pause();
  document.querySelector('html').classList.remove('playvideo');
  playButton.querySelector('span').textContent = 'Play';
  playBtnBlue.textContent = 'Play';
});
//Video Play Pause Control End
//Video Sound on & off Ctrl Start
let soundOff = document.getElementById("sound-off");
let soundOn = document.getElementById("sound-on");
let soundCtrl = document.querySelector(".sound-ctrl");

soundOff.addEventListener("click", function () {
  video.muted = true;
  soundCtrl.classList.add('soundctrlshow');
});

soundOn.addEventListener("click", function () {
  video.muted = false;
  soundCtrl.classList.remove('soundctrlshow');
});
//Video Sound on & off Ctrl End
video.onended = function () {
  document.querySelector('html').classList.remove('playvideo');
  playButton.querySelector('span').textContent = 'Play';
  playBtnBlue.textContent = 'Play';
};


// Start Slider3D 
/*
|------------------------------------------------------
|  JS: Swiper
|------------------------------------------------------
*/

const swiperContainer = document.querySelector('.swiper-container');
if (swiperContainer) {
  var swiper = new Swiper('.swiper-container', {
    slidesPerView: 3.4,
    spaceBetween: 25,
    breakpoints: {
      1024: {
        slidesPerView: 3.4,
        spaceBetween: 25,
      },
      768: {
        slidesPerView: 2.4,
        spaceBetween: 25,
      },
      640: {
        slidesPerView: 1.4,
        spaceBetween: 25,
      },
      320: {
        slidesPerView: 1.1,
        spaceBetween: 25,
      }
    },
    centeredSlides: true,
    grabCursor: true,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    slideToClickedSlide: true,
  });
}

const homeTestimonialsSwiperEl = document.querySelector('.home-testimonials-swiper');
if (homeTestimonialsSwiperEl && typeof Swiper !== 'undefined') {
  new Swiper('.home-testimonials-swiper', {
    slidesPerView: 1.05,
    spaceBetween: 16,
    grabCursor: true,
    loop: true,
    loopAdditionalSlides: 3,
    speed: 700,
    autoplay: {
      delay: 4500,
      disableOnInteraction: false,
      pauseOnMouseEnter: true,
    },
    breakpoints: {
      480: {
        slidesPerView: 1.12,
        spaceBetween: 18,
      },
      640: {
        slidesPerView: 1.35,
        spaceBetween: 20,
      },
      768: {
        slidesPerView: 1.65,
        spaceBetween: 22,
      },
      900: {
        slidesPerView: 1.85,
        spaceBetween: 24,
      },
      1200: {
        slidesPerView: 2.5,
        spaceBetween: 28,
      },
    },
    navigation: {
      nextEl: '.home-testimonials-next',
    },
  });
}

/*
|------------------------------------------------------
|  JS: Cards with Fullscreen zoom
|------------------------------------------------------
*/


// Dog Notifications

// Array of random notifications
const notifications = [
  "“Woof, woof” That’s Welcome in dog.",
  "Did you know? Hatch is a homegrown Dubai studio.",
  "We dig into design & get our hands dirty.",
  "Our team can speak more than 5 languages."
  // Add more notifications as needed
];

let soundPlayed = false;
let imageShown = false;


function showRandomNotification() {
  const randomIndex = Math.floor(Math.random() * notifications.length);
  const randomNotification = notifications[randomIndex];
  document.getElementById('notification').innerText = randomNotification;

  const notificationSound = document.getElementById('notificationSound');


  // تشغيل الرنة إذا لم تكن قد تم تشغيلها بالفعل
  if (!soundPlayed) {
    // notificationSound.play();
    soundPlayed = true;

    // إعادة تعيين الحالة بعد فترة زمنية (هنا 2 ثانية)
    setTimeout(() => {
      soundPlayed = false;
    }, 100);
  }

  // عرض الصورة إذا لم تكن قد تم عرضها بالفعل
  if (!imageShown) {
    shakeDog();
    imageShown = true;

    // إعادة تعيين الحالة بعد فترة زمنية (هنا 500 مللي ثانية)
    setTimeout(() => {
      imageShown = false;
    }, 100);
  }

  // استمع لحدث انتهاء التشغيل لتفعيل الاهتزاز بعد انتهاء الصوت
  notificationSound.onended = () => {
    shakeDog();
  };
}


function shakeDog() {
  const dogImage = document.getElementById('dogImage');
  // dogImage.style.animation = 'shake 0.5s';
  setTimeout(() => {
    dogImage.style.animation = '';
  }, 500);
}
function popUp() {
  const notification = document.getElementById('notification');
  notification.style.scale = 0;

  setTimeout(() => {
    notification.style.scale = 1;
  }, 500);
}


// استمع لحدث النقر لتحديث الإشعار والاهتزاز
document.getElementById('dog').addEventListener('click', () => {
  popUp();
  showRandomNotification();
});


// تحديث الإشعار بشكل دوري
// setInterval(() => {
//   showRandomNotification();
// }, 20000);

window.addEventListener('load', function () {
  if (typeof initHomeScrollEffects === 'function') {
    initHomeScrollEffects();
  }
});
