@php
    $images = $shortcode->images ?? [];

    if (is_string($images)) {
        $decoded = json_decode($images, true);
        $images = is_array($decoded) ? $decoded : array_filter(array_map('trim', explode(',', $images)));
    }

    $images = array_values(array_filter((array) $images));
    $imageUrls = array_map(fn($image) => RvMedia::getImageUrl($image), $images);
@endphp

@once
    <link rel="stylesheet" href="{{ Theme::asset()->url('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ Theme::asset()->url('css/about.css') }}">
    <script src="{{ Theme::asset()->url('js/about.js') }}" defer></script>
@endonce

@if (!empty($imageUrls))
    <div class="">
        <div class="w-100 h-100 d-flex justify-content-center">
            <img id="strips" src="{{ $imageUrls[0] }}" data-images='@json($imageUrls)' class="img-fluid"
                alt="" loading="lazy" />
        </div>
    </div>
@endif
