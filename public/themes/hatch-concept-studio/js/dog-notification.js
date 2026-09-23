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

    if (document.readyState === 'loading') {
        document.addEventListener(
            'DOMContentLoaded',
            initDogNotification,
            { once: true }
        );
    } else {
        initDogNotification();
    }
})();