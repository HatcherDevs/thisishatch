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

  let currentIndex = -1;
  let isOpen = false;

  function showNextMessage() {
    if (!notificationElement || notifications.length === 0) {
      return;
    }

    currentIndex = (currentIndex + 1) % notifications.length;
    notificationElement.textContent = notifications[currentIndex];
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

  function popUp() {
    if (!notificationElement) {
      return;
    }

    notificationElement.style.scale = 0;

    setTimeout(() => {
      notificationElement.style.scale = 1;
    }, 120);
  }


  function openBubble() {
    if (!dogElement || !notificationElement || notifications.length === 0 || isOpen) {
      return;
    }

    showNextMessage();
    dogElement.classList.add('is-open');
    isOpen = true;
    popUp();
    shakeDog();
  }

  function closeBubble() {
    if (!dogElement || !isOpen) {
      return;
    }

    dogElement.classList.remove('is-open');
    isOpen = false;
  }

  if (dogElement) {
    dogElement.addEventListener('mouseenter', openBubble);
    dogElement.addEventListener('mouseleave', closeBubble);
    dogElement.addEventListener('click', () => {
      if (isOpen) {
        closeBubble();

        return;
      }

      openBubble();
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




