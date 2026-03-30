// Add a check for mobile devices
const isMobile = window.innerWidth <= 767; // You can adjust this breakpoint based on your design


function locomotive() {
  gsap.registerPlugin(ScrollTrigger);

  const locoScroll = new LocomotiveScroll({
    el: document.querySelector("#main"),
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
  return `imgs/horse-webp/turn02_${n}.webp`;
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


ScrollTrigger.create({
  trigger: "#page>canvas",
  pin: true,
  scroller: `#main`,
  start: `top top`,
  end: `500% top`,
  onUpdate: (self) => {

    if (self.isActive) {
      // Show images when scrolling within the specified range
      gsap.set(".click_graphics", { opacity: 1, pointerEvents: "auto", duration: 0.5 });
    } else {
      // Hide images when scrolling outside the specified range
      gsap.set(".click_graphics", { opacity: 0, pointerEvents: "none" });
      gsap.set("#page2", { opacity: 1, pointerEvents: "auto", duration: 0.5 });
      gsap.set("#page3", { opacity: 1, pointerEvents: "auto", duration: 0.5 });
    }
  },
});




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
  ease: "power2.inOut", // يمكنك تغيير هذا حسب التفضيلات
  duration: 2, // يمكنك ضبط مدة التأثير
  delay: 1.5, // يمكنك ضبط تأخير بداية التأثير
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
  var spanV = cursor.querySelector('span')
  var page2 = document.getElementById('page2')
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
  })



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
playButton.addEventListener("click", function () {
  video.play();
  playBtnBlue.innerText = "stop";
  playButton.classList.add('vplay');
  pauseButton.classList.remove('vpause');
  document.querySelector('html').classList.add('playvideo');
});

pauseButton.addEventListener("click", function () {
  video.pause();
  playBtnBlue.innerText = "play";
  playButton.classList.remove('vplay');
  pauseButton.classList.add('vpause');
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
  playButton.classList.remove('vplay');
  playBtnBlue.innerText = "play";

};


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
