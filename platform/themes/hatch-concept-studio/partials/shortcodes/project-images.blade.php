@php
    $layout = $shortcode->layout ?? 'full-image';

    $images = $shortcode->images ?? [];

    if (is_string($images)) {
        $decodedImages = json_decode($images, true);

        $images = is_array($decodedImages) ? $decodedImages : explode(',', $images);
    }

    if (!is_array($images)) {
        $images = [];
    }

    $images = array_values(array_filter(array_map('trim', $images)));

    $requiredImages = match ($layout) {
        'full-image' => 1,
        'two-inline' => 2,
        'two-vertical' => 2,
        'three-inline' => 3,
        default => 1,
    };

    $images = array_slice($images, 0, $requiredImages);
@endphp

@if ($layout === 'full-image' && isset($images[0]))
    <section class="pd2-fullimg">
        <img src="{{ RvMedia::getImageUrl($images[0]) }}" alt="{{ __('Project image') }}" />
    </section>
@endif

@if ($layout === 'two-inline' && count($images) >= 2)
    <section class="pd2-grid pd2-grid--2">
        @foreach ($images as $image)
            <img src="{{ RvMedia::getImageUrl($image) }}"
                alt="{{ __('Project image :number', [
                    'number' => $loop->iteration,
                ]) }}" />
        @endforeach
    </section>
@endif

@if ($layout === 'two-vertical' && count($images) >= 2)
    <section class="pd2-grid pd2-grid--2 pd2-grid--stagger">
        @foreach ($images as $image)
            <img class="{{ $loop->odd ? 'pd2-stagger-left' : 'pd2-stagger-right' }}"
                src="{{ RvMedia::getImageUrl($image) }}"
                alt="{{ __('Project image :number', [
                    'number' => $loop->iteration,
                ]) }}" />
        @endforeach
    </section>
@endif
@if ($layout === 'three-inline' && count($images) >= 3)
    <section class="pd2-three-inline">
        @foreach (array_slice($images, 0, 3) as $image)
            <img
                src="{{ RvMedia::getImageUrl($image) }}"
                alt="{{ __('Project image :number', [
                    'number' => $loop->iteration,
                ]) }}"
            />
        @endforeach
    </section>
@endif