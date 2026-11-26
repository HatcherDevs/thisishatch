@php
    $title = $shortcode->title ?? null;
    $description = $shortcode->description ?? null;

    $title = $title ? trim(htmlspecialchars_decode($title, ENT_QUOTES)) : null;

    $description = $description ? htmlspecialchars_decode($description, ENT_QUOTES) : null;

    if ($description) {
        $description = preg_replace('/\\\\r?\\\\n\r?\n?/', "\n", $description);

        $description = implode("\n", array_map('trim', explode("\n", (string) $description)));
    }
@endphp


<section class="pd2-midtext">
    <h2>{{ $title }}</h2>
    <p>
        {!! nl2br(e($description)) !!}
    </p>
</section>
