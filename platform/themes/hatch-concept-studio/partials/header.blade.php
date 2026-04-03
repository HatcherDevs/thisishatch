<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    {!! SeoHelper::render() !!}

    <!-- Geo targeting (Dubai) -->
    <meta name="geo.region" content="AE-DU" />
    <meta name="geo.placename" content="Dubai" />
    <meta name="geo.position" content="25.2048;55.2708" />
    <meta name="ICBM" content="25.2048, 55.2708" />

    <!-- Performance: DNS Prefetch & Preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://kit.fontawesome.com" crossorigin />
    <link rel="dns-prefetch" href="https://kit.fontawesome.com" />
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com" />

    @php
        $favicon = theme_option('website_favicon');
        $appleIcon = theme_option('website_apple_icon');
        $faviconUrl = $favicon ? RvMedia::getImageUrl($favicon) : Theme::asset()->url('imgs/hatch-logo.ico');
        $appleIconUrl = $appleIcon ? RvMedia::getImageUrl($appleIcon) : $faviconUrl;
    @endphp
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ $faviconUrl }}" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ $appleIconUrl }}" />

    <!-- Preload critical above-fold CSS -->
    <link rel="preload" href="{{ Theme::asset()->url('css/style.css') }}" as="style" />

    <link rel="stylesheet" href="{{ Theme::asset()->url('css/locomotive-scroll.css') }}" />
    <link rel="stylesheet" href="{{ Theme::asset()->url('css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ Theme::asset()->url('css/slider3D.css') }}" />
    <script src="https://kit.fontawesome.com/7b5e9f3ec6.js" crossorigin="anonymous" defer></script>
    <link rel="stylesheet" href="{{ Theme::asset()->url('css/style.css') }}" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap-grid.min.css" />

    @php
        $bodyId = (string) Theme::getBodyAttribute('id');
        $isSingleProjectPage = str_starts_with($bodyId, 'project-');
    @endphp

    @if ($isSingleProjectPage)
        <link rel="stylesheet" href="{{ Theme::asset()->url('css/bootstrap.min.css') }}" />
        <link rel="stylesheet" href="{{ Theme::asset()->url('css/about.css') }}" />
        <link rel="stylesheet" href="{{ Theme::asset()->url('css/projects.css') }}" />
    @endif
</head>

<body {!! Theme::bodyAttributes() !!}>
    {!! apply_filters(THEME_FRONT_BODY, null) !!}
    @php
        $menuIcon = theme_option('header_menu_icon');
        $menuLogo = theme_option('header_logo');
        $menuTitle = theme_option('header_menu_title', 'This is Hatch');
        $menuIconUrl = $menuIcon ? RvMedia::getImageUrl($menuIcon) : Theme::asset()->url('imgs/side_menu.png');
        $menuLogoUrl = $menuLogo ? RvMedia::getImageUrl($menuLogo) : Theme::asset()->url('imgs/hatch_logo_white.png');
    @endphp
    <div id="nav" role="navigation" aria-label="Main navigation">
        <a href="#menu" aria-label="Open navigation menu"><img src="{{ $menuIconUrl }}" width="66%"
                alt="Menu" /></a>
    </div>

    <div class="popover" id="menu">
        <div class="content">
            <a href="#" class="close"></a>
            <a href="#" class="hatch_logo">
                <img class="mouseMove_hover" src="{{ $menuLogoUrl }}" alt="Hatch Concept Studio logo" />
            </a>

            <div class="nav">
                @if (Menu::isLocationHasMenu('main-menu'))
                    {!! Menu::renderMenuLocation('main-menu', [
                        'view' => 'main-menu',
                        'options' => ['class' => 'nav_list'],
                    ]) !!}
                @else
                    <ul class="nav_list">
                        <li class="nav_list_item"><a href="{{ url('/about') }}">About</a></li>
                        <li class="nav_list_item"><a href="{{ url('/projects') }}">Projects</a></li>
                        <li class="nav_list_item"><a href="{{ url('/contact') }}">Contact</a></li>
                        <li class="nav_list_item"><a href="{{ url('/store') }}">Store</a></li>
                    </ul>
                @endif
            </div>
            <div class="this_is_hatch">
                <h1>{{ $menuTitle }}</h1>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var closeBtn = document.querySelector('.popover .close');
            if (closeBtn) {
                closeBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    if (window.location.hash === '#menu') {
                        window.location.hash = '';
                    } else {
                        // fallback: إخفاء العنصر مباشرة لو لم يكن هناك hash
                        var popover = document.getElementById('menu');
                        if (popover) popover.classList.remove('active');
                    }
                });
            }
        });
    </script>
</body>

</html>
