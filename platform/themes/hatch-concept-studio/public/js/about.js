//////////////////////////////////////////////////////////////////////


(function () {
  if (window.__aboutJsLoaded) {
    return;
  }
  window.__aboutJsLoaded = true;
  const links = document.querySelectorAll('a');
  const cursor = document.querySelector('.cursor');
  const dogImage = document.getElementById('dogImage');

  const editCursor = e => {
    const { clientX: x, clientY: y } = e;
    if (!cursor) {
      return;
    }

    cursor.style.left = x + 'px';
    cursor.style.top = y + 'px';
  };

  if (dogImage && cursor) {
    dogImage.addEventListener('mouseenter', () => {
      cursor.style.transform = 'scale(2)';
    });
    dogImage.addEventListener('mouseleave', () => {
      cursor.style.transform = '';
    });
  }

  if (cursor) {
    links.forEach(link => {
      link.addEventListener('mouseenter', () => {
        cursor.style.transform = 'scale(3)';
      });

      link.addEventListener('mouseleave', () => {
        cursor.style.transform = '';
      });
    });

    document.addEventListener('mousemove', editCursor);
  }

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
    const notification = document.getElementById('notification');
    const notificationSound = document.getElementById('notificationSound');

    if (!notification || !notificationSound) {
      return;
    }

    const randomIndex = Math.floor(Math.random() * notifications.length);
    const randomNotification = notifications[randomIndex];
    notification.innerText = randomNotification;

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
    if (!dogImage) {
      return;
    }
    // dogImage.style.animation = "shake 0.5s";
    setTimeout(() => {
      dogImage.style.animation = "";
    }, 500);
  }

  // استمع لحدث النقر لتحديث الإشعار والاهتزاز
  function popUp() {
    const notification = document.getElementById('notification');
    if (!notification) {
      return;
    }

    notification.style.scale = 0;

    setTimeout(() => {
      notification.style.scale = 1;
    }, 500);
  }


  // استمع لحدث النقر لتحديث الإشعار والاهتزاز
  const dog = document.getElementById('dog');
  if (dog) {
    dog.addEventListener('click', () => {
      popUp();
      showRandomNotification();
    });
  }

  // تحديث الإشعار بشكل دوري
  // setInterval(() => {
  //   showRandomNotification();
  // }, 20000);
  //////////////////////////////////////////////////////////////////////



  //////////////////////////////////////////////////////////////////////
  // احصل على عنصر navbar باستخدام ID الخاص به
  const navAbout = document.getElementById('nav_about');
  // احصل على عنصر main باستخدام ID الخاص به
  const mainDiv = document.getElementById('main');
  if (navAbout && mainDiv) {
    // احصل على ارتفاع عنصر navbar
    const navHeight = navAbout.offsetHeight;
    // قم بتعيين قيمة padding-top بناءً على ارتفاع navbar
    mainDiv.style.paddingTop = `${navHeight}px`;
  }
  //////////////////////////////////////////////////////////////////////


  //////////////////////////////// Start strips ////////////////////////////////////
  // قائمة بأسماء الصور
  const imageElement = document.getElementById('strips');
  let images = [];

  if (imageElement) {
    const dataImages = imageElement.getAttribute('data-images');
    if (dataImages) {
      try {
        images = JSON.parse(dataImages) || [];
      } catch (e) {
        images = [];
      }
    }

    if (!images.length) {
      images = [
        "imgs/about/full.png",
        "imgs/about/full0.png",
        "imgs/about/full1.png",
        "imgs/about/full2.png",
        "imgs/about/full3.png"
      ];
    }

    // متغير لتتبع الصورة الحالية
    let currentIndex = 0;

    // وظيفة لتحديث الصورة بانسيابية
    function updateImage() {
      imageElement.style.animation = 'none';
      imageElement.offsetHeight;
      imageElement.style.animation = 'fadeIn 1s ease-in-out';

      currentIndex = (currentIndex + 1) % images.length;
      imageElement.src = images[currentIndex];
    }

    setInterval(updateImage, 9000);
    updateImage();
  }

  //////////////////////////////// End strips ////////////////////////////////////
})();




