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
        background-color: {{ $preloaderBackgroundColor }};
    }

    .preloader-spinner--ring {
        border-top-color: {{ $preloaderSpinnerColor }};
        border-bottom-color: {{ $preloaderSpinnerColor }};
    }

    .preloader-spinner--dots::before,
    .preloader-spinner--dots::after,
    .preloader-spinner--dots span {
        background: {{ $preloaderSpinnerColor }};
    }

    .preloader-spinner--pulse {
        background: {{ $preloaderSpinnerColor }};
    }
</style>

<div class="preloader" id="preloader" aria-hidden="true" data-behavior="{{ $preloaderBehavior }}"
    data-display-mode="{{ $preloaderDisplayMode }}" data-fixed-time-ms="{{ $preloaderFixedTimeMs }}">
    @if ($preloaderStyle === 'dots')
        <div class="preloader-spinner preloader-spinner--dots">
            <span></span>
        </div>
    @elseif ($preloaderStyle === 'pulse')
        <div class="preloader-spinner preloader-spinner--pulse"></div>
    @else
        <div class="preloader-spinner preloader-spinner--ring"></div>
    @endif
</div>
