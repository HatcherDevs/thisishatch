@php
    $videoUrl = $shortcode->video_url;

    $autoPlay = in_array((string) ($shortcode->autoplay ?? '0'), ['1', 'true', 'yes'], true);
    $mute = in_array((string) ($shortcode->mute ?? '1'), ['1', 'true', 'yes'], true);
    $loop = in_array((string) ($shortcode->loop ?? '0'), ['1', 'true', 'yes'], true);
@endphp

@if ($videoUrl)
    <section class="hatch-video-section" style="padding: 40px 0;">
        <div class="container">
            <div class="video-custom" style="border-radius: 16px; overflow: hidden; background: #000;">
                <video width="100%" playsinline controls @if ($autoPlay) autoplay @endif
                    @if ($mute) muted @endif @if ($loop) loop @endif>
                    <source src="{{ $videoUrl }}" />
                </video>
            </div>
        </div>
    </section>
@endif
