@php
    $videoUrl = $shortcode->video_url ?? null;
    $coverImage = $shortcode->cover_image ?? null;

    $youtubeId = null;
    $vimeoId = null;

    if ($videoUrl) {
        if (preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]+)/', $videoUrl, $matches)) {
            $youtubeId = $matches[1];
        } elseif (preg_match('/vimeo\.com\/(?:video\/)?(\d+)/', $videoUrl, $matches)) {
            $vimeoId = $matches[1];
        }
    }

    $defaultPoster = Theme::asset()->url('imgs/timeline-video.png');
    $posterImage = $defaultPoster;

    if ($coverImage) {
        $coverImage = trim((string) $coverImage);

        if (filter_var($coverImage, FILTER_VALIDATE_URL)) {
            $posterImage = $coverImage;
        } elseif (str_starts_with($coverImage, '/themes/')) {
            $posterImage = $coverImage;
        } else {
            $posterImage = RvMedia::getImageUrl($coverImage, null, false, $defaultPoster);
        }
    }
    // dd($shortcode, $coverImage, $posterImage, $defaultPoster);
    $autoPlay = in_array(strtolower((string) ($shortcode->autoplay ?? '0')), ['1', 'true', 'yes'], true);

    $mute = in_array(strtolower((string) ($shortcode->mute ?? '1')), ['1', 'true', 'yes'], true);

    $loop = in_array(strtolower((string) ($shortcode->loop ?? '0')), ['1', 'true', 'yes'], true);

    $headline =
        $shortcode->headline ??
        'A homegrown creative studio<br />
            shaping brands through<br />
            considered design, compelling<br />
            ideas, and purposeful campaigns.';
@endphp

@if ($videoUrl)
    <div id="page2">
        <div class="hero-video-section">

            <h2 class="hero-video-headline">
                {!! $headline !!}
            </h2>

            <div class="video-custom">
                

                @if ($youtubeId)
                    <iframe id="video" src="https://www.youtube.com/embed/{{ $youtubeId }}?enablejsapi=1&rel=0"
                        title="{{ __('Video section') }}" loading="lazy"
                        allow="autoplay; encrypted-media; picture-in-picture" allowfullscreen></iframe>
                @elseif ($vimeoId)
                    <iframe id="video" src="https://player.vimeo.com/video/{{ $vimeoId }}"
                        title="{{ __('Video section') }}" loading="lazy"
                        allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                @else
                    <video id="video" width="100%" playsinline preload="metadata" poster="{{ $posterImage }}"
                        @if ($autoPlay) autoplay @endif @if ($mute) muted @endif
                        @if ($loop) loop @endif>
                        <source src="{{ $videoUrl }}" data-wf-ignore="true" />
                    </video>
                @endif

                <div class="video-cover" id="video-cover" style="background-image: url('{{ $posterImage }}');"></div>

                <!--Volume Control Start-->
                <div class="sound-ctrl">
                    <img src="" alt="Volume" />

                    <button class="off-button" id="sound-off" type="button">
                        OFF
                    </button>

                    <button class="on-button" id="sound-on" type="button">
                        ON
                    </button>
                </div>
                <!--Volume Control End-->

            </div>
        </div>
    </div>
@endif
