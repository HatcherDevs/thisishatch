@php
    $currentLocale = app()->getLocale();
    $direction = in_array($currentLocale, ['ar', 'he', 'ur', 'fa']) ? 'rtl' : 'ltr';
@endphp
<!DOCTYPE html>
<html lang="{{ $currentLocale }}" dir="{{ $direction }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {!! Theme::header() !!}

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600;700&display=swap"
        rel="stylesheet">



    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css" rel="stylesheet" />
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js"></script>

    <!-- Theme Styles -->
    {{--
    <link rel="stylesheet" href="{{ Theme::asset()->url('css/style.css') }}">
    <link rel="stylesheet" href="{{ Theme::asset()->url('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ Theme::asset()->url('css/footer.css') }}"> --}}

    @if ($direction === 'ltr')
    <link rel="stylesheet"
        href="{{ Theme::asset()->url('css/main.css') }}?v={{ filemtime(public_path('themes/sharjah-triennial/css/main.css')) }}">

    @elseif ($direction === 'rtl')
    <link rel="stylesheet"
        href="{{ Theme::asset()->url('css/rtl/main.css') }}?v={{ filemtime(public_path('themes/sharjah-triennial/css/rtl/main.css')) }}">
    @endif

    {!! Theme::asset()->styles() !!}
    {!! Theme::asset()->container('header')->styles() !!}
    {!! Theme::asset()->container('header')->scripts() !!}

        @stack('css')
</head>

{{-- <body class="{{ theme_option('body_class', 'home') }} @yield('body_class')"> --}}
<body >

    {{-- {!! Theme::partial('preloader') !!} --}}

    {!! Theme::partial('header') !!}

        @yield('content')

    {!! Theme::partial('footer') !!}

    {!! Theme::partial('back-to-top') !!}

    <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script
        src="{{ Theme::asset()->url('js/custom.js') }}?v={{ filemtime(public_path('themes/sharjah-triennial/js/custom.js')) }}"></script>
    <script
        src="{{ Theme::asset()->url('js/map.js') }}?v={{ filemtime(public_path('themes/sharjah-triennial/js/map.js')) }}"></script>


    {!! Theme::asset()->scripts() !!}
    {!! Theme::asset()->container('footer')->styles() !!}
    {!! Theme::asset()->container('footer')->scripts() !!}
    {!! Theme::footer() !!}

    @stack('footer')
</body>

</html>