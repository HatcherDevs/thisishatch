@php
    $videoUrl = $shortcode->video_url;
    $coverImage = $shortcode->cover_image;
    $defaultPoster = Theme::asset()->url('imgs/timeline-video.png');
    $posterImage = $defaultPoster;

    if ($coverImage) {
        if (filter_var($coverImage, FILTER_VALIDATE_URL)) {
            $posterImage = $coverImage;
        } elseif (str_starts_with($coverImage, 'imgs/')) {
            $posterImage = Theme::asset()->url($coverImage);
        } elseif (str_starts_with($coverImage, '/themes/')) {
            $posterImage = $coverImage;
        } elseif (!str_contains($coverImage, '/')) {
            $posterImage = Theme::asset()->url('imgs/' . ltrim($coverImage, '/'));
        } else {
            $posterImage = RvMedia::getImageUrl($coverImage, null, false, $defaultPoster);
        }
    }

    $autoPlay = in_array((string) ($shortcode->autoplay ?? '0'), ['1', 'true', 'yes'], true);
    $mute = in_array((string) ($shortcode->mute ?? '1'), ['1', 'true', 'yes'], true);
    $loop = in_array((string) ($shortcode->loop ?? '0'), ['1', 'true', 'yes'], true);
@endphp

@if ($videoUrl)
    <div id="page2" class="hatch-video-section">
        <div class="video-custom">
            <div class="play-pause">
                <a class="play-btn btnVideo" id="play_button"><i></i></a>
                <a id="pause_button" class="pause-btn btnVideo"><i></i></a>
            </div>
            <video id="video" width="100%" playsinline preload="metadata" poster="{{ $posterImage }}"
                @if ($autoPlay) autoplay @endif @if ($mute) muted @endif
                @if ($loop) loop @endif>
                <source src="{{ $videoUrl }}" data-wf-ignore="true" />
            </video>

            <div class="sound-ctrl">
                <img src="" alt="Volume" />
                <button class="off-button" id="sound-off" type="button">OFF</button>
                <button class="on-button" id="sound-on" type="button">ON</button>
            </div>
        </div>
    </div>
@endif
