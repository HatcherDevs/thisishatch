// Add a check for mobile devices
const isMobile = window.innerWidth <= 767; // You can adjust this breakpoint based on your design


function locomotive() {
  const mainElement = document.querySelector("#main");
  const isHomePage = document.querySelector("#page") !== null;

  if (!mainElement || !isHomePage || typeof LocomotiveScroll === 'undefined') {
    return;
  }

  gsap.registerPlugin(ScrollTrigger);

  const locoScroll = new LocomotiveScroll({
    el: mainElement,
    smooth: true,
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

    pinType: mainElement.style.transform
      ? "transform"
      : "fixed",
  });
  ScrollTrigger.addEventListener("refresh", () => locoScroll.update());
  ScrollTrigger.refresh();
}
locomotive();

// Move hero scroll indicator outside #main so position:fixed works correctly
// with LocomotiveScroll (which uses transforms on #main)
(function () {
  const indicator = document.querySelector('.hero-scroll-indicator');
  if (indicator) {
    document.body.appendChild(indicator);
  }
})();

const heroScrollIndicator = document.querySelector('.hero-scroll-indicator');

const canvas = document.querySelector("canvas");
if (canvas) {
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
      trigger: `#page>canvas`,
      start: `top top`,
      end: `600% top`,
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

  // Modify the media query for mobile devices
  if (isMobile) {
    gsap.to(imageSeq, {
      frame: frameCount - 1,
      snap: "frame",
      ease: `none`,
      scrollTrigger: {
        scrub: 0.15,
        trigger: `#page>canvas`,
        start: `top top`,
        end: `600% top`,
        scroller: `#main`,
      },
      onUpdate: render,
    });
  }


  gsap.set(".click_graphics", { opacity: 1, pointerEvents: "auto" });

  ScrollTrigger.create({
    trigger: "#page>canvas",
    pin: true,
    scroller: `#main`,
    start: `top top`,
    end: `500% top`,
    onEnter: () => {
      gsap.set(".click_graphics", { opacity: 1, pointerEvents: "auto" });
    },
    onEnterBack: () => {
      gsap.set(".click_graphics", { opacity: 1, pointerEvents: "auto" });
    },
    onLeave: () => {
      gsap.set(".click_graphics", { opacity: 0, pointerEvents: "none" });
    },
    onLeaveBack: () => {
      gsap.set(".click_graphics", { opacity: 1, pointerEvents: "auto" });
    },
  });

  if (heroScrollIndicator) {
    ScrollTrigger.create({
      trigger: "#page>canvas",
      scroller: "#main",
      start: "top top",
      end: "500% top",
      onToggle: (self) => {
        gsap.to(heroScrollIndicator, {
          autoAlpha: self.isActive ? 1 : 0,
          duration: 0.3,
          overwrite: true,
        });
      },
    });
  }

  gsap.to("#page3", {
    scrollTrigger: {
      trigger: "#page",
      start: "bottom top", // Trigger when the bottom of #page reaches the top of the viewport
      end: "+=100%", // Adjust this value based on your design
      pin: true, // Pin #page1 during the scroll
      pinSpacing: false, // Disable automatic spacing adjustment
      scroller: "#main",
      scrub: true, // Smoothly transition between #page and #page1
    },
  });
}



const layoutOverlay = document.querySelector(".layout");
const heroHorseBlock = document.querySelector(".hatch-hero-horse");

if (layoutOverlay && heroHorseBlock) {
  const introOverlayTimeline = gsap.timeline();
  introOverlayTimeline
    .set(".layout", { bottom: "100%", opacity: 1, display: "block" })
    .to(".layout", {
      bottom: 0,
      opacity: 1,
      ease: "power2.inOut",
      duration: 2,
      delay: 0.8,
    })
    .to(".layout", {
      opacity: 0,
      ease: "power2.inOut",
      duration: 1.2,
    }, "+=1.2")
    .set(".layout", { display: "none" });
} else if (layoutOverlay) {
  gsap.set(".layout", { display: "none", opacity: 0 });
}

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

  if (!cursor) {
    return;
  }

  const editCursor = e => {
    const { clientX: x, clientY: y } = e;
    cursor.style.left = x + 'px';
    cursor.style.top = y + 'px';
  };

  links.forEach(link => {
    link.addEventListener('mouseenter', () => {
      cursor.style.transform = 'scale(4)';
    });

    link.addEventListener('mouseleave', () => {
      cursor.style.transform = '';
    });
  });

  document.addEventListener('mousemove', editCursor);
  const btnVideo = document.querySelector('.btnVideo');

  // const editCursorVideo = e => {
  //   const { clientX: x, clientY: y } = e;
  //   btnVideo.style.left = x + 'px';
  //   btnVideo.style.top = y + 'px';
  // };
  var spanV = cursor.querySelector('span');
  var page2 = document.getElementById('page2');

  if (page2 && spanV) {
    page2.addEventListener('mousemove', function () {
      spanV.style.display = "block";
      cursor.style.transform = 'scale(4)';
      cursor.style.backgroundColor = 'blue';
      cursor.style.mixBlendMode = 'normal';
    });
    page2.addEventListener('mouseleave', function () {
      spanV.style.display = "none";
      cursor.style.transform = 'scale(1)';
      cursor.style.backgroundColor = '#fff';
      cursor.style.color = '#fff';
      cursor.style.mixBlendMode = 'difference';
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
let video = document.querySelector('video');
let pendingPlayPromise = null;

if (playButton && playBtnBlue && pauseButton && video) {
  playButton.addEventListener("click", function () {
    pendingPlayPromise = video.play();

    if (pendingPlayPromise && typeof pendingPlayPromise.catch === 'function') {
      pendingPlayPromise.catch(function (error) {
        if (!error || error.name !== 'AbortError') {
          console.error(error);
        }
      });
    }

    playBtnBlue.innerText = "stop";
    playButton.classList.add('vplay');
    pauseButton.classList.remove('vpause');
    document.querySelector('html').classList.add('playvideo');
  });

  pauseButton.addEventListener("click", function () {
    pendingPlayPromise = null;
    video.pause();
    playBtnBlue.innerText = "play";
    playButton.classList.remove('vplay');
    pauseButton.classList.add('vpause');
  });
}
//Video Play Pause Control End
//Video Sound on & off Ctrl Start
let soundOff = document.getElementById("sound-off");
let soundOn = document.getElementById("sound-on");
let soundCtrl = document.querySelector(".sound-ctrl");

if (soundOff && soundOn && soundCtrl && video) {
  soundOff.addEventListener("click", function () {
    video.muted = true;
    soundCtrl.classList.add('soundctrlshow');
  });

  soundOn.addEventListener("click", function () {
    video.muted = false;
    soundCtrl.classList.remove('soundctrlshow');
  });
}
//Video Sound on & off Ctrl End
if (video && playButton && playBtnBlue) {
  video.onended = function () {
    document.querySelector('html').classList.remove('playvideo');
    playButton.classList.remove('vplay');
    playBtnBlue.innerText = "play";
  };
}


// Start Slider3D 
/*
|------------------------------------------------------
|  JS: Swiper
|------------------------------------------------------
*/

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
  // pagination: {
  // 	el: '.swiper-pagination',
  // 	clickable: true,
  // },
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
  slideToClickedSlide: true,
});

/*
|------------------------------------------------------
|  JS: Cards with Fullscreen zoom
|------------------------------------------------------
*/


// Dog Notifications
(function () {
  const dogElement = document.getElementById('dog');
  const notificationElement = document.getElementById('notification');
  const dogImage = document.getElementById('dogImage');

  if (!dogElement || !notificationElement) {
    return;
  }

  let notifications = [];
  try {
    const rawMessages = dogElement.getAttribute('data-dog-messages') || '[]';
    notifications = JSON.parse(rawMessages);
  } catch (error) {
    notifications = [];
  }

  if (!Array.isArray(notifications)) {
    notifications = [];
  }

  notifications = notifications.filter((message) => {
    return typeof message === 'string' && message.trim() !== '';
  });

  if (notifications.length === 0) {
    return;
  }

  let currentIndex = -1;
  let isOpen = false;

  const showNextMessage = () => {
    currentIndex = (currentIndex + 1) % notifications.length;
    notificationElement.textContent = notifications[currentIndex];
  };

  const popUp = () => {
    notificationElement.style.scale = 0;

    setTimeout(() => {
      notificationElement.style.scale = 1;
    }, 120);
  };

  const shakeDog = () => {
    if (!dogImage) {
      return;
    }

    setTimeout(() => {
      dogImage.style.animation = '';
    }, 500);
  };

  const openBubble = () => {
    showNextMessage();
    dogElement.classList.add('is-open');
    isOpen = true;
    popUp();
    shakeDog();
  };

  const closeBubble = () => {
    if (!isOpen) {
      notificationElement.style.scale = 0;

      return;
    }

    dogElement.classList.remove('is-open');
    notificationElement.style.scale = 0;
    isOpen = false;
  };

  const rerunOpenEvent = () => {
    closeBubble();

    window.setTimeout(() => {
      openBubble();
    }, 120);
  };

  dogElement.addEventListener('mouseenter', openBubble);
  dogElement.addEventListener('mouseleave', closeBubble);
  dogElement.addEventListener('click', () => {
    rerunOpenEvent();
  });
})();
