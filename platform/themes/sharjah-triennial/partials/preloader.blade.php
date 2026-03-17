<!-- Preloader -->
<div id="preloader" class="preloader">
    <div class="preloader-inner">
        <div class="loader-animation">
            <div class="loader-circle"></div>
            <div class="loader-circle"></div>
            <div class="loader-circle"></div>
        </div>
        <p class="mt-3 text-white fw-semibold">{{ __('Loading...') }}</p>
    </div>
</div>

<style>
    .preloader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        transition: opacity 0.5s ease, visibility 0.5s ease;
    }

    .preloader.hidden {
        opacity: 0;
        visibility: hidden;
    }

    .preloader-inner {
        text-align: center;
    }

    .loader-animation {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }

    .loader-circle {
        width: 15px;
        height: 15px;
        background: #0f3460;
        border-radius: 50%;
        animation: bounce 1.4s infinite ease-in-out both;
    }

    .loader-circle:nth-child(1) {
        animation-delay: -0.32s;
    }

    .loader-circle:nth-child(2) {
        animation-delay: -0.16s;
    }

    @keyframes bounce {

        0%,
        80%,
        100% {
            transform: scale(0);
            opacity: 0.5;
        }

        40% {
            transform: scale(1);
            opacity: 1;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const preloader = document.getElementById('preloader');

        if (preloader) {
            // Hide preloader after page load
            window.addEventListener('load', function () {
                setTimeout(function () {
                    preloader.classList.add('hidden');
                    // Remove from DOM after transition
                    setTimeout(function () {
                        preloader.remove();
                    }, 500);
                }, 300);
            });
        }
    });
</script>