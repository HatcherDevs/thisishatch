@php
    $title = $shortcode->title ?: 'This is Hatch';
    $subtitle = $shortcode->subtitle ?: 'Homegrown creative studio helping brands stand out.';
    $buttonText = $shortcode->button_text;
    $buttonUrl = $shortcode->button_url ?: '#';
    $horseImage = $shortcode->horse_image ?: Theme::asset()->url('imgs/horse-webp/turn02_0000.webp');
@endphp

<section class="hatch-hero-horse" style="padding: 80px 0 40px;">
    <div class="container">
        <div class="row align-items-center gy-4">
            <div class="col-lg-6">
                <h1 style="font-size: clamp(2rem, 6vw, 4.5rem); line-height: 1.05; margin-bottom: 16px;">
                    {{ $title }}
                </h1>
                <p style="font-size: 1.125rem; max-width: 44ch; margin-bottom: 24px;">
                    {{ $subtitle }}
                </p>

                @if ($buttonText)
                    <a href="{{ $buttonUrl }}" class="custom-link-footer" style="font-size: 1rem;">
                        <span>{{ $buttonText }}</span>
                    </a>
                @endif
            </div>

            <div class="col-lg-6 text-center">
                <img src="{{ $horseImage }}" alt="Horse visual"
                    style="width: min(100%, 520px); height: auto; object-fit: contain;" loading="lazy">
            </div>
        </div>
    </div>
</section>
