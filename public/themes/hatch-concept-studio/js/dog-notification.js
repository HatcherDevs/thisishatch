(function () {
    function initDogNotification() {
        const dogElement = document.getElementById('dog');
        const notificationElement =
            document.getElementById('notification');

        if (!dogElement || !notificationElement) {
            return;
        }

        let messages = [];
        const loopMode =
            dogElement.getAttribute('data-dog-loop') === 'yes';

        try {
            const rawMessages =
                dogElement.getAttribute(
                    'data-dog-messages'
                ) || '[]';

            messages = JSON.parse(rawMessages);
        } catch (error) {
            messages = [];
        }

        if (!Array.isArray(messages)) {
            messages = [];
        }

        messages = messages.filter(function (message) {
            return (
                typeof message === 'string' &&
                message.trim() !== ''
            );
        });

        if (messages.length === 0) {
            return;
        }

        notificationElement.textContent = messages[0];

        if (!loopMode || messages.length < 2) {
            return;
        }

        let currentIndex = 0;

        window.setInterval(function () {
            currentIndex =
                (currentIndex + 1) % messages.length;

            notificationElement.textContent =
                messages[currentIndex];
        }, 3000);
    }

    function initDogCursorHover() {
        const dogElement = document.getElementById('dog');
        const cursorElement = document.querySelector('.cursor');

        if (!dogElement || !cursorElement) {
            return;
        }

        // الكيرسور المخصص يكبّر حجمه لما الماوس يعدّي على الكلب
        dogElement.addEventListener('mouseenter', function () {
            cursorElement.classList.add('is-dog-hover');
        });

        dogElement.addEventListener('mouseleave', function () {
            cursorElement.classList.remove('is-dog-hover');
        });
    }

    function init() {
        initDogNotification();
        initDogCursorHover();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init, {
            once: true,
        });
    } else {
        init();
    }
})();