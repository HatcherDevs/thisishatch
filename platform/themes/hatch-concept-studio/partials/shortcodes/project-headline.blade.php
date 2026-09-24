@php
    $title = $shortcode->title ?? null;
    $description = $shortcode->description ?? null;

    $title = $title ? trim(htmlspecialchars_decode($title, ENT_QUOTES)) : null;

    $description = $description ? htmlspecialchars_decode($description, ENT_QUOTES) : null;

    $description = $description ? str_replace(['\\n', '\\r\\n'], ["\n", "\r\n"], $description) : null;
@endphp


<section class="pd2-midtext">
    <h2>{{ $title }}</h2>
    <p>
        {{ $description }}
    </p>
</section>
