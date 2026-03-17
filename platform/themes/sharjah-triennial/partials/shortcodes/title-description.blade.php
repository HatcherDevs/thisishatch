@php
    $title = $shortcode->title ?? '';
    $description = $shortcode->description ?? '';
@endphp

@if($title)
<hr class="divider" style="
    border: none;
    border-bottom: 3px solid #000;
    width: 100%;
">
    <h2 class="my-1" style="font-size: 26px">{{ $title }}</h2>
    <hr class="divider" style="
        border: none;
        border-top: 3px solid #000;
        width: 100%;
        /* border-bottom: 3px solid #000; */
    ">
@endif

@if($description)
    <p class="mt-2 mb-4" style="line-height: normal; padding-top: 10px">
        {!! nl2br(e($description)) !!}
    </p>
@endif