@php
    $preloaderStyle = (string) theme_option('preloader_style', 'ring');
    $preloaderBackgroundColor = (string) theme_option('preloader_background_color', '#ffffff');
    $preloaderSpinnerColor = (string) theme_option('preloader_spinner_color', '#ff2b4a');
    $preloaderBehavior = (string) theme_option('preloader_behavior', 'assets_loaded');
    $preloaderDisplayMode = (string) theme_option('preloader_display_mode', 'every_page');
    $preloaderFixedTimeMs = (int) theme_option('preloader_fixed_time_ms', 1500);

    if ($preloaderFixedTimeMs < 0) {
        $preloaderFixedTimeMs = 0;
    }
@endphp

<style>
    .preloader {
        position: fixed;
        inset: 0;
        z-index: 99999;
        background-color: {{ $preloaderBackgroundColor }};
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 1;
        visibility: visible;
        transition: opacity .35s ease, visibility .35s ease;
    }

    .preloader.is-hidden {
        opacity: 0;
        visibility: hidden;
    }

    .preloader-spinner {
        position: relative;
    }

    .preloader-spinner--ring {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        border: 2px solid transparent;
        border-top-color: {{ $preloaderSpinnerColor }};
        border-bottom-color: {{ $preloaderSpinnerColor }};
        animation: hatch-preloader-ring .6s linear infinite;
    }

    .preloader-spinner--dots {
        width: 60px;
        height: 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .preloader-spinner--dots::before,
    .preloader-spinner--dots::after,
    .preloader-spinner--dots span {
        content: '';
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: {{ $preloaderSpinnerColor }};
        animation: hatch-preloader-dots .9s infinite ease-in-out;
    }

    .preloader-spinner--dots::before {
        animation-delay: -0.24s;
    }

    .preloader-spinner--dots span {
        animation-delay: -0.12s;
    }

    .preloader-spinner--pulse {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: {{ $preloaderSpinnerColor }};
        animation: hatch-preloader-pulse 1s ease-in-out infinite;
    }

    @keyframes hatch-preloader-ring {
        from {
            transform: rotate(0deg);
        }

        to {
            transform: rotate(360deg);
        }
    }

    @keyframes hatch-preloader-dots {

        0%,
        80%,
        100% {
            transform: scale(0.6);
            opacity: 0.45;
        }

        40% {
            transform: scale(1);
            opacity: 1;
        }
    }

    @keyframes hatch-preloader-pulse {
        0% {
            transform: scale(0.78);
            opacity: 0.55;
        }

        70% {
            transform: scale(1);
            opacity: 1;
        }

        100% {
            transform: scale(0.78);
            opacity: 0.55;
        }
    }
</style>

<div class="preloader" id="preloader" aria-hidden="true">
    @if ($preloaderStyle === 'dots')
        <div class="preloader-spinner preloader-spinner--dots"><span></span></div>
    @elseif ($preloaderStyle === 'pulse')
        <div class="preloader-spinner preloader-spinner--pulse"></div>
    @else
        <div class="preloader-spinner preloader-spinner--ring"></div>
    @endif
</div>

<script>
    (function() {
        var preloaderElement = document.getElementById('preloader');

        if (!preloaderElement) {
            return;
        }

        var hidePreloader = function() {
            preloaderElement.classList.add('is-hidden');

            window.setTimeout(function() {
                if (preloaderElement && preloaderElement.parentNode) {
                    preloaderElement.parentNode.removeChild(preloaderElement);
                }
            }, 450);
        };

        var preloaderBehavior = @json($preloaderBehavior);
        var preloaderDisplayMode = @json($preloaderDisplayMode);
        var preloaderFixedTimeMs = {{ $preloaderFixedTimeMs }};
        var sessionStorageKey = 'hatch_preloader_seen';

        if (preloaderDisplayMode === 'once_per_session') {
            try {
                if (window.sessionStorage && window.sessionStorage.getItem(sessionStorageKey) === '1') {
                    preloaderElement.parentNode.removeChild(preloaderElement);
                    return;
                }
            } catch (error) {
                // Ignore storage read issues and continue with normal preloader flow.
            }
        }

        if (preloaderBehavior === 'fixed_time') {
            window.setTimeout(hidePreloader, preloaderFixedTimeMs);
            return;
        }

        window.addEventListener('load', hidePreloader, {
            once: true
        });

        if (preloaderDisplayMode === 'once_per_session') {
            try {
                if (window.sessionStorage) {
                    window.sessionStorage.setItem(sessionStorageKey, '1');
                }
            } catch (error) {
                // Ignore storage write issues and continue without persistence.
            }
        }
    })();
</script>
