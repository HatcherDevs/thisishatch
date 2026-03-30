<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
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

    @if(request()->is('/') || request()->is(''))
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
        @if(request()->is('projects*') || request()->is('contact*') || request()->is('store*') || request()->is('project-details*'))
            <link rel="stylesheet" href="{{ Theme::asset()->url('css/projects.css') }}" />
            <link rel="stylesheet" href="{{ Theme::asset()->url('css/swiper-bundle.min.css') }}" />
        @endif
    @endif

    {!! Theme::asset()->styles() !!}
</head>
<body {!! Theme::bodyAttributes() !!}>
    {!! apply_filters(THEME_FRONT_BODY, null) !!}

    {{-- Side menu toggle --}}
    <div id="{{ request()->is('/') || request()->is('') ? 'nav' : 'nav_about' }}"@if(!request()->is('/') && !request()->is('')) style="opacity:1"@endif role="navigation" aria-label="Main navigation">
        <a href="#menu" aria-label="Open navigation menu">
            <img src="{{ Theme::asset()->url('imgs/side_menu.png') }}" width="66%" alt="Menu" />
        </a>
    </div>

    {{-- Slide-out menu --}}
    <div class="popover" id="menu">
        <div class="content">
            <a href="#" class="close" aria-label="Close menu"></a>
            <a href="{{ route('public.index') }}" class="hatch_logo">
                <img class="mouseMove_hover" src="{{ Theme::asset()->url('imgs/hatch_logo_white.png') }}" alt="Hatch Concept Studio" />
            </a>

            <div class="{{ request()->is('/') || request()->is('') ? 'nav' : 'nav_about' }}">
                <ul class="nav_list {{ !request()->is('/') && !request()->is('') ? 'pl-0' : '' }}">
                    <div class="nav_list_item{{ request()->is('about*') ? ' active' : '' }}">
                        <li><a href="{{ route('public.single', 'about') }}">About</a></li>
                    </div>
                    <div class="nav_list_item{{ request()->is('projects*') ? ' active' : '' }}">
                        <li><a href="{{ route('public.single', 'projects') }}">Projects</a></li>
                    </div>
                    <div class="nav_list_item{{ request()->is('contact*') ? ' active' : '' }}">
                        <li><a href="{{ route('public.single', 'contact') }}">Contact</a></li>
                    </div>
                    <div class="nav_list_item{{ request()->is('store*') ? ' active' : '' }}">
                        <li><a href="{{ route('public.single', 'store') }}">Store</a></li>
                    </div>
                </ul>
            </div>
            <div class="this_is_hatch">
                <h1>This is Hatch</h1>
            </div>
        </div>
    </div>

    @if(request()->is('/') || request()->is(''))
        {{-- Homepage floating click graphics --}}
        <span class="click_graphics at mouseMove_hover" data-speed="2">
            <img width="100%" src="{{ Theme::asset()->url('imgs/click_graphics/at.png') }}" alt="Creative agency Dubai social media marketing" />
        </span>
        <span class="click_graphics click mouseMove_hover" data-speed="4">
            <img width="100%" src="{{ Theme::asset()->url('imgs/click_graphics/click.png') }}" alt="Digital marketing agency Dubai click engagement" />
        </span>
        <span class="click_graphics text mouseMove_hover" data-speed="6">
            <img width="100%" src="{{ Theme::asset()->url('imgs/click_graphics/text.png') }}" alt="Brand identity design and content marketing Dubai" />
        </span>
        <span class="click_graphics like mouseMove_hover" data-speed="8">
            <img width="100%" src="{{ Theme::asset()->url('imgs/click_graphics/like.png') }}" alt="Social media marketing and brand engagement Dubai" />
        </span>
        <span class="click_graphics hashtah mouseMove_hover" data-speed="10">
            <img width="100%" src="{{ Theme::asset()->url('imgs/click_graphics/hashtah.png') }}" alt="Integrated marketing campaigns creative agency Dubai" />
        </span>
    @endif
