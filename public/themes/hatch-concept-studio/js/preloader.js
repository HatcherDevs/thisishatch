(function () {
    const preloaderElement = document.getElementById('preloader');

    if (!preloaderElement) {
        return;
    }

    const preloaderBehavior =
        preloaderElement.dataset.behavior || 'assets_loaded';

    const preloaderDisplayMode =
        preloaderElement.dataset.displayMode || 'every_page';

    const preloaderFixedTimeMs = Math.max(
        parseInt(
            preloaderElement.dataset.fixedTimeMs || '1500',
            10
        ),
        0
    );

    const sessionStorageKey = 'hatch_preloader_seen';

    function removePreloader() {
        if (
            preloaderElement &&
            preloaderElement.parentNode
        ) {
            preloaderElement.parentNode.removeChild(
                preloaderElement
            );
        }
    }

    function hidePreloader() {
        preloaderElement.classList.add('is-hidden');

        window.setTimeout(removePreloader, 450);
    }

    if (
        preloaderDisplayMode === 'once_per_session'
    ) {
        try {
            if (
                window.sessionStorage &&
                window.sessionStorage.getItem(
                    sessionStorageKey
                ) === '1'
            ) {
                removePreloader();

                return;
            }
        } catch (error) {
            // Ignore storage read issues.
        }
    }

    if (preloaderBehavior === 'fixed_time') {
        window.setTimeout(
            hidePreloader,
            preloaderFixedTimeMs
        );
    } else if (document.readyState === 'complete') {
        hidePreloader();
    } else {
        window.addEventListener(
            'load',
            hidePreloader,
            { once: true }
        );
    }

    if (
        preloaderDisplayMode === 'once_per_session'
    ) {
        try {
            if (window.sessionStorage) {
                window.sessionStorage.setItem(
                    sessionStorageKey,
                    '1'
                );
            }
        } catch (error) {
            // Ignore storage write issues.
        }
    }
})();