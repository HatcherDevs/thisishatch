(function () {
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const isMobile = window.innerWidth <= 767;

  function canAnimate() {
    return typeof gsap !== 'undefined' && typeof ScrollTrigger !== 'undefined' && !prefersReducedMotion;
  }

  function revealElements(selector, options) {
    const {
      scroller = window,
      y = 72,
      scale = 0.94,
      duration = 1.05,
      stagger = 0.1,
      start = 'top 88%',
      useY = true,
    } = options;

    gsap.utils.toArray(selector).forEach((el, index) => {
      const fromVars = {
        autoAlpha: 0,
        scale,
      };

      const toVars = {
        autoAlpha: 1,
        scale: 1,
        duration,
        ease: 'power3.out',
        delay: (index % 4) * stagger,
        scrollTrigger: {
          trigger: el,
          scroller,
          start,
          toggleActions: 'play none none none',
          once: true,
        },
      };

      if (useY) {
        fromVars.y = y;
        toVars.y = 0;
      }

      gsap.fromTo(el, fromVars, toVars);
    });
  }

  function parallaxY(selector, options) {
    const {
      scroller = window,
      amount = 48,
      scrub = 0.65,
    } = options;

    gsap.utils.toArray(selector).forEach((el, index) => {
      const direction = index % 2 === 0 ? 1 : -1;
      const travel = isMobile ? amount * 0.45 : amount;

      gsap.fromTo(
        el,
        { y: travel * direction * -0.35 },
        {
          y: travel * direction * 0.65,
          ease: 'none',
          scrollTrigger: {
            trigger: el.closest('[data-parallax-trigger]') || el.parentElement || el,
            scroller,
            start: 'top bottom',
            end: 'bottom top',
            scrub,
          },
        }
      );
    });
  }

  function parallaxScale(selector, options) {
    const {
      scroller = window,
      fromScale = 1.12,
      toScale = 1,
      scrub = 0.75,
    } = options;

    gsap.utils.toArray(selector).forEach((el) => {
      gsap.fromTo(
        el,
        { scale: fromScale },
        {
          scale: toScale,
          ease: 'none',
          scrollTrigger: {
            trigger: el.closest('[data-parallax-trigger]') || el.parentElement || el,
            scroller,
            start: 'top bottom',
            end: 'bottom top',
            scrub,
          },
        }
      );
    });
  }

  window.initHomeScrollEffects = function initHomeScrollEffects() {
    if (!canAnimate()) {
      return;
    }

    gsap.registerPlugin(ScrollTrigger);

    const scroller = '#main';
    const portfolioSection = document.querySelector('.home-portfolio-section');
    if (!portfolioSection) {
      return;
    }

    revealElements('.home-portfolio-section .portfolio-item', {
      scroller,
      y: isMobile ? 40 : 84,
      scale: 0.95,
      stagger: 0.08,
    });

    revealElements('.home-portfolio-section .portfolio-deco', {
      scroller,
      y: isMobile ? 24 : 56,
      scale: 0.88,
      stagger: 0.06,
      start: 'top 92%',
    });

    if (!isMobile) {
      parallaxScale('.home-portfolio-section .portfolio-media img', {
        scroller,
        fromScale: 1.14,
        scrub: 0.85,
      });

      parallaxY('.home-portfolio-section .portfolio-deco', {
        scroller,
        amount: 72,
        scrub: 0.45,
      });
    }

    ScrollTrigger.refresh();
  };

  function revealPd2Slider() {
    const slider = document.querySelector('.pd2-slider');
    if (!slider) {
      return;
    }

    const slideImages = gsap.utils.toArray('.pd2-slider .swiper-slide img');
    const nav = slider.querySelector('.pd2-project-nav');
    const swiperEl = slider.querySelector('.pd2-swiper');

    if (!slideImages.length) {
      return;
    }

    gsap.set(slideImages, { autoAlpha: 0, y: isMobile ? 36 : 72, scale: 0.94 });
    if (nav) {
      gsap.set(nav, { autoAlpha: 0, y: 28 });
    }

    const tl = gsap.timeline({
      scrollTrigger: {
        trigger: slider,
        start: 'top 86%',
        toggleActions: 'play none none none',
        once: true,
      },
    });

    tl.to(slideImages, {
      autoAlpha: 1,
      y: 0,
      scale: 1,
      duration: 1,
      ease: 'power3.out',
      stagger: 0.14,
    });

    if (nav) {
      tl.to(
        nav,
        {
          autoAlpha: 1,
          y: 0,
          duration: 0.8,
          ease: 'power3.out',
        },
        '-=0.45'
      );
    }

    if (!isMobile && swiperEl) {
      gsap.fromTo(
        swiperEl,
        { y: -36 },
        {
          y: 36,
          ease: 'none',
          scrollTrigger: {
            trigger: slider,
            start: 'top bottom',
            end: 'bottom top',
            scrub: 0.75,
          },
        }
      );

      parallaxScale('.pd2-slider .swiper-slide img', {
        fromScale: 1.12,
        scrub: 0.85,
      });
    }
  }

  window.initPd2ScrollEffects = function initPd2ScrollEffects() {
    if (!canAnimate()) {
      return;
    }

    gsap.registerPlugin(ScrollTrigger);

    const targets = '.pd2-grid img, .pd2-fullimg img, .pd2-slider';
    if (!document.querySelector(targets)) {
      return;
    }

    revealElements('.pd2-grid:not(.pd2-grid--stagger) img, .pd2-fullimg img', {
      y: isMobile ? 36 : 72,
      scale: 0.95,
      stagger: 0.12,
      useY: true,
    });

    revealElements('.pd2-stagger-left, .pd2-stagger-right', {
      scale: 0.95,
      stagger: 0.15,
      useY: false,
    });

    revealPd2Slider();

    if (!isMobile) {
      parallaxScale('.pd2-grid:not(.pd2-grid--stagger) img, .pd2-fullimg img', {
        fromScale: 1.1,
        scrub: 0.8,
      });

      parallaxY('.pd2-stagger-left', { amount: 52 });
      parallaxY('.pd2-stagger-right', { amount: 88 });
    }

    ScrollTrigger.refresh();
  };
})();
