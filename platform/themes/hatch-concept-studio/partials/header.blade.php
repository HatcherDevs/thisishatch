<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    @php
        $isHome = request()->is('/') || request()->is('') || request()->is('home');
    @endphp

    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    {!! Theme::header() !!}

    <!-- Performance: DNS Prefetch & Preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://kit.fontawesome.com" crossorigin />
    <link rel="dns-prefetch" href="https://kit.fontawesome.com" />
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com" />

    <script src="https://kit.fontawesome.com/7b5e9f3ec6.js" crossorigin="anonymous" defer></script>

    @if ($isHome)
        {{-- Homepage CSS --}}
        <link rel="preload" href="{{ Theme::asset()->url('css/style.css') }}" as="style" />
        <link rel="stylesheet" href="{{ Theme::asset()->url('css/locomotive-scroll.css') }}" />
        <link rel="stylesheet" href="{{ Theme::asset()->url('css/swiper-bundle.min.css') }}" />
        <link rel="stylesheet" href="{{ Theme::asset()->url('css/slider3D.css') }}" />
        <link rel="stylesheet" href="{{ Theme::asset()->url('css/style.css') }}" />
    @else
        {{-- Inner pages CSS --}}
        <link rel="stylesheet" href="{{ Theme::asset()->url('css/bootstrap.min.css') }}" />
        <link rel="stylesheet" href="{{ Theme::asset()->url('css/about.css') }}" />
        @if (request()->is('projects*') ||
                request()->is('contact*') ||
                request()->is('store*') ||
                request()->is('project-details*'))
            <link rel="stylesheet" href="{{ Theme::asset()->url('css/projects.css') }}" />
            <link rel="stylesheet" href="{{ Theme::asset()->url('css/swiper-bundle.min.css') }}" />
        @endif
    @endif

    {!! Theme::asset()->styles() !!}
</head>

<body {!! Theme::bodyAttributes() !!}>
    {!! apply_filters(THEME_FRONT_BODY, null) !!}
    <div id="nav" role="navigation" aria-label="Main navigation">
      <a href="#menu" aria-label="Open navigation menu"
        ><img src="imgs/side_menu.png" width="66%" alt="Menu"
      /></a>
    </div>

    <div class="popover" id="menu">
      <div class="content">
        <a href="#" class="close"></a>
        <a href="#" class="hatch_logo">
          <img
            class="mouseMove_hover"
            src="imgs/hatch_logo_white.png"
            alt="Hatch Concept Studio logo"
          />
        </a>

        <div class="nav">
          <ul class="nav_list">
            <div class="nav_list_item">
              <li><a href="about.html">About</a></li>
            </div>
            <div class="nav_list_item">
              <li><a href="projects.html">Projects</a></li>
            </div>
            <div class="nav_list_item">
              <li><a href="contact.html">Contact</a></li>
            </div>
            <div class="nav_list_item">
              <li><a href="store.html">Store</a></li>
            </div>
          </ul>
        </div>
        <div class="this_is_hatch">
          <h1>This is Hatch</h1>
        </div>
      </div>
    </div>
   