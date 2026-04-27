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
  const dogElement = document.getElementById('dog');
  const notificationElement = document.getElementById('notification');
  const loopMode = dogElement && dogElement.getAttribute('data-dog-loop') === 'yes';

  let notifications = [];

  if (dogElement) {
    try {
      const rawMessages = dogElement.getAttribute('data-dog-messages') || '[]';
      notifications = JSON.parse(rawMessages);
    } catch (error) {
      notifications = [];
    }
  }

  if (!Array.isArray(notifications)) {
    notifications = [];
  }

  notifications = notifications.filter((message) => {
    return typeof message === 'string' && message.trim() !== '';
  });

  let currentIndex = 0;

  if (notificationElement && notifications.length > 0) {
    notificationElement.textContent = notifications[currentIndex];
  }

  function showRandomNotification() {
    if (!notificationElement || notifications.length === 0) {
      return;
    }

    if (notifications.length === 1) {
      popUp();
      shakeDog();

      return;
    }

    let nextIndex = currentIndex;

    while (nextIndex === currentIndex) {
      nextIndex = Math.floor(Math.random() * notifications.length);
    }

    currentIndex = nextIndex;
    notificationElement.textContent = notifications[currentIndex];
    popUp();
    shakeDog();
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
    if (!notificationElement) {
      return;
    }

    notificationElement.style.scale = 0;

    setTimeout(() => {
      notificationElement.style.scale = 1;
    }, 120);
  }


  // استمع لحدث النقر لتحديث الإشعار والاهتزاز
  if (dogElement) {
    dogElement.addEventListener('click', showRandomNotification);
  }

  if (loopMode && notificationElement && notifications.length > 1) {
    window.setInterval(() => {
      currentIndex = (currentIndex + 1) % notifications.length;
      notificationElement.textContent = notifications[currentIndex];
      popUp();
    }, 3000);
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




