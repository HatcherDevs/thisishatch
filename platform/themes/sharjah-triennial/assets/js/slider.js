// Enhanced Slider with Bootstrap Carousel transitions
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.custom-slider').forEach(function (slider) {
        // جلب الصور والكابشنات من الـ HTML
        let images = [];
        slider.querySelectorAll('.slider-data > div').forEach(function (div) {
            images.push({
                src: div.getAttribute('data-src'),
                caption: div.getAttribute('data-caption')
            });
        });
        
        let index = 0;
        const containerEl = slider.querySelector('.slider-container');
        const prevImgEl = slider.querySelector('.prev-img');
        const currentImgEl = slider.querySelector('.current-img');
        const nextImgEl = slider.querySelector('.next-img');
        const captionEl = slider.querySelector('.slider-caption');
        const countEl = slider.querySelector('.slider-count');
        const prevBtn = slider.querySelector('.slider-prev');
        const nextBtn = slider.querySelector('.slider-next');
        const zoomBtn = slider.querySelector('.slider-zoom');
        let isTransitioning = false;

        function loadImages() {
            const prevIndex = (index - 1 + images.length) % images.length;
            const nextIndex = (index + 1) % images.length;
            
            prevImgEl.src = images[prevIndex].src;
            currentImgEl.src = images[index].src;
            nextImgEl.src = images[nextIndex].src;
            
            captionEl.textContent = images[index].caption;
            countEl.textContent = (index + 1) + '/' + images.length;
        }

        function update(direction = 'next') {
            if (isTransitioning) return;
            
            isTransitioning = true;
            
            // إضافة كلاس Bootstrap Carousel
            if (direction === 'next') {
                containerEl.classList.add('carousel-item-next');
            } else {
                containerEl.classList.add('carousel-item-prev');
            }
            
            // بعد انتهاء الانتقال
            setTimeout(function() {
                // تحديث الفهرس
                if (direction === 'next') {
                    index = (index + 1) % images.length;
                } else {
                    index = (index - 1 + images.length) % images.length;
                }
                
                // تحميل الصور الجديدة
                loadImages();
                
                // إعادة تعيين موضع الـ container بدون transition
                containerEl.style.transition = 'none';
                containerEl.classList.remove('carousel-item-next', 'carousel-item-prev', 'carousel-item-start');
                containerEl.style.transform = 'translateX(-33.33%)';
                
                // إعادة تفعيل transition بعد إعادة التعيين
                setTimeout(function() {
                    containerEl.style.transition = 'transform 0.6s ease-in-out';
                    isTransitioning = false;
                }, 50);
            }, 600);
        }

        prevBtn.onclick = function () {
            update('prev');
        };
        
        nextBtn.onclick = function () {
            update('next');
        };

        // دعم السحب بالماوس والتاتش
        let startX = 0, endX = 0, isDragging = false;
        const imgWrap = slider.querySelector('.slider-img-wrap');
        
        imgWrap.addEventListener('touchstart', function (e) {
            startX = e.touches[0].clientX;
        });
        imgWrap.addEventListener('touchend', function (e) {
            endX = e.changedTouches[0].clientX;
            handleSwipe();
        });
        imgWrap.addEventListener('mousedown', function (e) {
            isDragging = true;
            startX = e.clientX;
        });
        imgWrap.addEventListener('mouseup', function (e) {
            if (!isDragging) return;
            isDragging = false;
            endX = e.clientX;
            handleSwipe();
        });
        imgWrap.addEventListener('mouseleave', function (e) {
            isDragging = false;
        });
        
        function handleSwipe() {
            if (isTransitioning) return;
            
            if (endX - startX > 50) {
                update('prev');
            } else if (startX - endX > 50) {
                update('next');
            }
        }
        
        // تحميل الصور الأولية
        loadImages();
    });

    // Enhanced Modal Slider
    (function () {
        // بيانات المودال
        let modalImages = [], modalIndex = 0;
        const overlay = document.getElementById('slider-modal-overlay');
        const imgEl = document.getElementById('slider-modal-img');
        const captionEl = document.getElementById('slider-modal-caption');
        const countEl = document.getElementById('slider-modal-count');
        const prevBtn = document.getElementById('slider-modal-prev');
        const nextBtn = document.getElementById('slider-modal-next');
        const closeBtn = document.getElementById('slider-modal-close');

        let isModalTransitioning = false;
        let modalDirection = 'next';
        
        function updateModal() {
            if (isModalTransitioning) return;
            
            isModalTransitioning = true;
            
            // تحديد اتجاه الانزلاق
            const slideOutTransform = modalDirection === 'next' ? 'translateX(-100%)' : 'translateX(100%)';
            const slideInTransform = modalDirection === 'next' ? 'translateX(100%)' : 'translateX(-100%)';
            
            // إضافة تأثير انزلاق للخروج
            imgEl.style.transform = slideOutTransform;
            
            setTimeout(function() {
                // تغيير الصورة والكابشن
                imgEl.src = modalImages[modalIndex].src;
                captionEl.textContent = modalImages[modalIndex].caption;
                countEl.textContent = (modalIndex + 1) + '/' + modalImages.length;
                
                // إعداد الصورة الجديدة للانزلاق من الاتجاه المعاكس
                imgEl.style.transform = slideInTransform;
                
                // إعادة تعيين التحويل للصورة الجديدة
                setTimeout(function() {
                    imgEl.style.transform = 'translateX(0)';
                    isModalTransitioning = false;
                }, 50);
            }, 300);
        }
        
        prevBtn.onclick = function () {
            modalDirection = 'prev';
            modalIndex = (modalIndex - 1 + modalImages.length) % modalImages.length;
            updateModal();
        };
        nextBtn.onclick = function () {
            modalDirection = 'next';
            modalIndex = (modalIndex + 1) % modalImages.length;
            updateModal();
        };
        closeBtn.onclick = function () {
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        };
        
        // دعم السحب في المودال
        let startX = 0, endX = 0, isDragging = false;
        imgEl.addEventListener('touchstart', function (e) {
            startX = e.touches[0].clientX;
        });
        imgEl.addEventListener('touchend', function (e) {
            endX = e.changedTouches[0].clientX;
            handleSwipe();
        });
        imgEl.addEventListener('mousedown', function (e) {
            isDragging = true;
            startX = e.clientX;
        });
        imgEl.addEventListener('mouseup', function (e) {
            if (!isDragging) return;
            isDragging = false;
            endX = e.clientX;
            handleSwipe();
        });
        imgEl.addEventListener('mouseleave', function (e) {
            isDragging = false;
        });
        
        function handleSwipe() {
            if (endX - startX > 50) {
                modalDirection = 'prev';
                modalIndex = (modalIndex - 1 + modalImages.length) % modalImages.length;
                updateModal();
            } else if (startX - endX > 50) {
                modalDirection = 'next';
                modalIndex = (modalIndex + 1) % modalImages.length;
                updateModal();
            }
        }
        
        // عند الضغط على أيقونة التكبير في أي سلايدر
        document.querySelectorAll('.custom-slider').forEach(function (slider) {
            const zoomBtn = slider.querySelector('.slider-zoom');
            if (!zoomBtn) return;
            zoomBtn.addEventListener('click', function (e) {
                e.preventDefault();
                // جلب الصور والكابشنات من السلايدر الحالي
                modalImages = [];
                slider.querySelectorAll('.slider-data > div').forEach(function (div) {
                    modalImages.push({
                        src: div.getAttribute('data-src'),
                        caption: div.getAttribute('data-caption')
                    });
                });
                // جلب الصورة الحالية
                const currentImg = slider.querySelector('.current-img').src;
                modalIndex = modalImages.findIndex(img => img.src === currentImg);
                if (modalIndex === -1) modalIndex = 0;
                updateModal();
                overlay.classList.add('active');
                document.body.style.overflow = 'hidden';
            });
        });
    })();
});
