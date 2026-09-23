(function () {
    function initMenuCloseButton() {
        const closeButton = document.querySelector(
            '.popover .close'
        );

        if (!closeButton) {
            return;
        }

        closeButton.addEventListener('click', function (event) {
            event.preventDefault();

            if (window.location.hash === '#menu') {
                window.location.hash = '';
                return;
            }

            const popover = document.getElementById('menu');

            if (popover) {
                popover.classList.remove('active');
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener(
            'DOMContentLoaded',
            initMenuCloseButton,
            { once: true }
        );
    } else {
        initMenuCloseButton();
    }
})();