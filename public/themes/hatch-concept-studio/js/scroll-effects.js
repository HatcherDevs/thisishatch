(function () {
    const prefersReducedMotion = window.matchMedia(
        '(prefers-reduced-motion: reduce)'
    ).matches;

    const isMobile = window.innerWidth <= 767;

    function canAnimate() {
        return (
            typeof gsap !== 'undefined' &&
            typeof ScrollTrigger !== 'undefined' &&
            !prefersReducedMotion
        );
    }

    function makeVisible(selector) {
        if (typeof gsap !== 'undefined') {
            gsap.set(selector, {
                autoAlpha: 1,
                opacity: 1,
                visibility: 'visible',
                x: 0,
                y: 0,
                scale: 1,
                clearProps: 'transform'
            });
        } else {
            document.querySelectorAll(selector).forEach(function (el) {
                el.style.opacity = '1';
                el.style.visibility = 'visible';
                el.style.transform = 'none';
            });
        }
    }

    function revealElements(selector, options = {}) {
        const {
            scroller = window,
            y = 72,
            scale = 0.94,
            duration = 1.05,
            stagger = 0.1,
            start = 'top 88%',
            useY = true
        } = options;

        const elements = gsap.utils.toArray(selector);

        if (!elements.length) {
            return;
        }

        elements.forEach(function (el, index) {
            const fromVars = {
                autoAlpha: 0,
                scale
            };

            const toVars = {
                autoAlpha: 1,
                scale: 1,
                duration,
                ease: 'power3.out',
                delay: (index % 4) * stagger,
                clearProps: 'transform',
                scrollTrigger: {
                    trigger: el,
                    scroller,
                    start,
                    toggleActions: 'play none none none',
                    once: true,
                    invalidateOnRefresh: true
                }
            };

            if (useY) {
                fromVars.y = y;
                toVars.y = 0;
            }

            gsap.fromTo(el, fromVars, toVars);
        });
    }

    function parallaxY(selector, options = {}) {
        const {
            scroller = window,
            amount = 48,
            scrub = 0.65
        } = options;

        gsap.utils.toArray(selector).forEach(function (el, index) {
            const direction = index % 2 === 0 ? 1 : -1;
            const travel = isMobile ? amount * 0.45 : amount;

            gsap.fromTo(
                el,
                {
                    y: travel * direction * -0.35
                },
                {
                    y: travel * direction * 0.65,
                    ease: 'none',
                    scrollTrigger: {
                        trigger:
                            el.closest('[data-parallax-trigger]') ||
                            el.parentElement ||
                            el,
                        scroller,
                        start: 'top bottom',
                        end: 'bottom top',
                        scrub,
                        invalidateOnRefresh: true
                    }
                }
            );
        });
    }

    function parallaxScale(selector, options = {}) {
        const {
            scroller = window,
            fromScale = 1.12,
            toScale = 1,
            scrub = 0.75
        } = options;

        gsap.utils.toArray(selector).forEach(function (el) {
            gsap.fromTo(
                el,
                {
                    scale: fromScale
                },
                {
                    scale: toScale,
                    ease: 'none',
                    scrollTrigger: {
                        trigger:
                            el.closest('[data-parallax-trigger]') ||
                            el.parentElement ||
                            el,
                        scroller,
                        start: 'top bottom',
                        end: 'bottom top',
                        scrub,
                        invalidateOnRefresh: true
                    }
                }
            );
        });
    }
    function getIsMobile() {
        return window.innerWidth <= 767;
    }


    function refreshScrollTriggers() {
        window.requestAnimationFrame(function () {
            const main = document.querySelector('#main');

            if (
                main &&
                main.__locomotiveScroll &&
                typeof main.__locomotiveScroll.update === 'function'
            ) {
                main.__locomotiveScroll.update();
            }

            // Do not call ScrollTrigger.refresh() here. With the Locomotive
            // scroller proxy, a forced refresh can write scrollTop(0) and
            // send the visitor back to the horse animation.
            if (typeof window.ScrollTrigger !== 'undefined') {
                window.ScrollTrigger.update();
            }
        });
    }


    window.initHomeScrollEffects = function initHomeScrollEffects() {
        // console.log('initHomeScrollEffects started');

        if (!canAnimate()) {
            return;
        }

        const isMobile = getIsMobile();

        gsap.registerPlugin(ScrollTrigger);

        const portfolioSection = document.querySelector(
            '.home-portfolio-section'
        );

        if (!portfolioSection) {
            console.warn(
                '.home-portfolio-section not found'
            );

            return;
        }

        revealElements(
            '.home-portfolio-section .portfolio-item',
            {
                scroller: '#main',
                y: isMobile ? 40 : 84,
                scale: 0.95,
                stagger: 0.08,
            }
        );

        revealElements(
            '.home-portfolio-section .portfolio-deco',
            {
                scroller: '#main',
                y: isMobile ? 24 : 56,
                scale: 0.88,
                stagger: 0.06,
                start: isMobile ? 'top bottom' : 'top 92%',
            }
        );

        // Use lighter values for the stacked mobile layout instead of disabling
        // parallax entirely. Reduced-motion users remain excluded by canAnimate().
        parallaxScale(
            '.home-portfolio-section .portfolio-media img',
            {
                scroller: '#main',
                fromScale: isMobile ? 1.06 : 1.14,
                scrub: isMobile ? 0.65 : 0.85,
            }
        );

        parallaxY(
            '.home-portfolio-section .portfolio-deco',
            {
                scroller: '#main',
                amount: isMobile ? 52 : 72,
                scrub: isMobile ? 0.6 : 0.45,
            }
        );

        refreshScrollTriggers();

        // console.log('Home scroll effects initialized');
    };
    window.initPd2ScrollEffects = function initPd2ScrollEffects() {
        const projectSelector =
            '.pd2-grid img, .pd2-fullimg img, .pd2-slider';

        const hasProjectElements =
            document.querySelector(projectSelector);

        if (!hasProjectElements) {
            return;
        }

        // في حالة عدم توفر GSAP أو وجود reduced motion:
        // اجعل الصور ظاهرة دائمًا.
        if (!canAnimate()) {
            makeVisible('.pd2-grid img, .pd2-fullimg img');
            return;
        }

        gsap.registerPlugin(ScrollTrigger);

        // إلغاء أي أنيميشن قديم على نفس العناصر
        gsap.killTweensOf(
            '.pd2-grid img, .pd2-fullimg img, .pd2-slider'
        );

        // مهم: نستخدم window لأن layout الحالي لا يحتوي على scroller مخصص
        const scroller = window;

        const regularImages = document.querySelectorAll(
            '.pd2-grid:not(.pd2-grid--stagger) img, .pd2-fullimg img'
        );

        const staggerImages = document.querySelectorAll(
            '.pd2-grid--stagger img, .pd2-stagger-left, .pd2-stagger-right'
        );

        if (regularImages.length) {
            revealElements(
                '.pd2-grid:not(.pd2-grid--stagger) img, .pd2-fullimg img',
                {
                    scroller,
                    y: isMobile ? 36 : 72,
                    scale: 0.95,
                    stagger: 0.12,
                    start: 'top 90%',
                    useY: true
                }
            );
        }

        if (staggerImages.length) {
            revealElements(
                '.pd2-grid--stagger img, .pd2-stagger-left, .pd2-stagger-right',
                {
                    scroller,
                    y: isMobile ? 24 : 42,
                    scale: 0.95,
                    stagger: 0.15,
                    start: 'top 92%',
                    useY: true
                }
            );
        }

        if (!isMobile) {
            parallaxScale(
                '.pd2-grid:not(.pd2-grid--stagger) img, .pd2-fullimg img',
                {
                    scroller,
                    fromScale: 1.08,
                    toScale: 1,
                    scrub: 0.8
                }
            );

            parallaxY(
                '.pd2-stagger-left',
                {
                    scroller,
                    amount: 52,
                    scrub: 0.7
                }
            );

            parallaxY(
                '.pd2-stagger-right',
                {
                    scroller,
                    amount: 88,
                    scrub: 0.7
                }
            );
        }

        // بعد إنشاء جميع الـ triggers، أعد حساب أماكن العناصر
        ScrollTrigger.refresh();

        // حماية إضافية:
        // لو ظل عنصر مخفيًا بعد وقت قصير، أظهره.
        window.setTimeout(function () {
            document
                .querySelectorAll('.pd2-grid img, .pd2-fullimg img')
                .forEach(function (image) {
                    const computedStyle = window.getComputedStyle(image);

                    if (
                        computedStyle.opacity === '0' ||
                        computedStyle.visibility === 'hidden'
                    ) {
                        gsap.set(image, {
                            autoAlpha: 1,
                            opacity: 1,
                            visibility: 'visible',
                            y: 0,
                            scale: 1,
                            clearProps: 'transform'
                        });
                    }
                });
        }, 1200);
    };
})();
