@php
    $title = $shortcode->title ?? '';
    $content = $shortcode->content ?? '';
    $image = $shortcode->image ?? '';
@endphp

<section class="section-model my-5">
    <div class="row">
        @if ($image)
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="section-model-image">
                    <img src="{{ RvMedia::getImageUrl($image) }}" alt="{{ $title }}" class="img-fluid" />
                </div>
            </div>
        @endif

        <div class="{{ $image ? 'col-lg-6' : 'col-12' }}">
            @if ($title)
                <hr class="divider" style="border: none; border-bottom: 3px solid #000; width: 100%;">
                <h2 class="my-1" style="font-size: 26px">{{ $title }}</h2>
                <hr class="divider" style="border: none; border-top: 3px solid #000; width: 100%;">
            @endif

            @if ($content)
                <div class="section-model-content mt-3">
                    {!! nl2br(e($content)) !!}
                </div>
            @endif
        </div>
    </div>
</section>
