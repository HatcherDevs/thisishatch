//////////////////////////////////////////////////////////////////////


  (function () {
    const links = document.querySelectorAll('a');
    const cursor = document.querySelector('.cursor');
    const dogImage = document.getElementById("dogImage");

    const editCursor = e => {
        const { clientX: x, clientY: y } = e;
        cursor.style.left = x + 'px';
        cursor.style.top = y + 'px';
      };

      dogImage.addEventListener('mouseenter', () => {
        cursor.style.transform = 'scale(2)';
      });
      dogImage.addEventListener('mouseleave', () => {
        cursor.style.transform = '';
      });

    links.forEach(link => {
      link.addEventListener('mouseenter', () => {
        cursor.style.transform = 'scale(3)';
      });
  
      link.addEventListener('mouseleave', () => {
        cursor.style.transform = '';
      });
    });
  
    document.addEventListener('mousemove', editCursor);

  
  })();
  
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
    document.getElementById("notification").innerText = randomNotification;

    const notificationSound = document.getElementById("notificationSound");

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
    const dogImage = document.getElementById("dogImage");
    // dogImage.style.animation = "shake 0.5s";
    setTimeout(() => {
      dogImage.style.animation = "";
    }, 500);
  }

  // استمع لحدث النقر لتحديث الإشعار والاهتزاز
  function popUp() {
    const notification = document.getElementById('notification');
    notification.style.scale=0;
  
    setTimeout(() => {
      notification.style.scale=1;
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
//////////////////////////////////////////////////////////////////////



//////////////////////////////////////////////////////////////////////
// احصل على عنصر navbar باستخدام ID الخاص به
const navAbout = document.getElementById('nav_about');
// احصل على ارتفاع عنصر navbar
const navHeight = navAbout.offsetHeight;
// احصل على عنصر main باستخدام ID الخاص به
const mainDiv = document.getElementById('main');
// قم بتعيين قيمة padding-top بناءً على ارتفاع navbar
mainDiv.style.paddingTop = `${navHeight}px`;
//////////////////////////////////////////////////////////////////////


//////////////////////////////// Start strips ////////////////////////////////////
// قائمة بأسماء الصور
const images = [
    "full.png",
    "full0.png",
    "full1.png",
    "full2.png",
    "full3.png"
];

// احصل على عنصر الصورة باستخدام ID الخاص بها
const imageElement = document.getElementById('strips');

// متغير لتتبع الصورة الحالية
let currentIndex = 0;

// وظيفة لتحديث الصورة بانسيابية
function updateImage() {
    // إزالة أي تأثير تلاشي حالي عن طريق إزالته ثم إعادة تعيينه
    imageElement.style.animation = 'none';
    imageElement.offsetHeight; // إعادة تعيين التمرير للعنصر
    imageElement.style.animation = 'fadeIn 1s ease-in-out';

    // تحديث الفهرس للانتقال إلى الصورة التالية
    currentIndex = (currentIndex + 1) % images.length;

    // تغيير مسار الصورة إلى المسار الجديد
    imageElement.src = `imgs/about/${images[currentIndex]}`;
}

// استدعاء وظيفة التحديث كل 40 ثانية (40000 ميلي ثانية)
setInterval(updateImage, 9000);

// تحديث الصورة الأولى عند تحميل الصفحة
updateImage();

//////////////////////////////// End strips ////////////////////////////////////




