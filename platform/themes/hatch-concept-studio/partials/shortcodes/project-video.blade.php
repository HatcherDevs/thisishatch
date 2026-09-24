@php
    $videoUrl = $shortcode->video_url ?? null;
    $coverImage = $shortcode->cover_image ?? null;

    $videoUrl = $videoUrl
        ? trim(str_replace(['\\"', '\\\\'], ['"', '\\'], htmlspecialchars_decode($videoUrl, ENT_QUOTES)))
        : null;

    $coverImage = $coverImage
        ? trim(str_replace(['\\"', '\\\\'], ['"', '\\'], htmlspecialchars_decode($coverImage, ENT_QUOTES)))
        : null;

    $coverUrl = $coverImage ? RvMedia::getImageUrl($coverImage) : null;

    $youtubeId = null;
    $vimeoId = null;

    if ($videoUrl) {
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $videoUrl, $matches)) {
            $youtubeId = $matches[1];
        } elseif (preg_match('/vimeo\.com\/(\d+)/', $videoUrl, $matches)) {
            $vimeoId = $matches[1];
        }
    }

    $videoId = 'projectVideo-' . uniqid();
    $coverId = $videoId . '-cover';
    $playButtonId = $videoId . '-play';
@endphp

@if ($videoUrl)
    <section class="pd2-video">
        <div class="pd2-video-wrap pd2-video-custom" id="{{ $videoId }}">
            @if ($youtubeId)
                <iframe id="{{ $videoId }}-media"
                    src="https://www.youtube.com/embed/{{ $youtubeId }}?enablejsapi=1&rel=0"
                    title="{{ __('Project video') }}" loading="lazy"
                    allow="autoplay; accelerometer; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen></iframe>
            @elseif ($vimeoId)
                <iframe id="{{ $videoId }}-media" src="https://player.vimeo.com/video/{{ $vimeoId }}"
                    title="{{ __('Project video') }}" loading="lazy" allow="autoplay; fullscreen; picture-in-picture"
                    allowfullscreen></iframe>
            @else
                <video id="{{ $videoId }}-media" poster="{{ $coverUrl }}" preload="metadata" playsinline
                    controls>
                    <source src="{{ $videoUrl }}" type="video/mp4">
                </video>
            @endif

            @if ($coverUrl)
                <div class="pd2-video-cover" id="{{ $coverId }}"
                    style="background-image: url('{{ $coverUrl }}');">
                </div>
            @endif

            <button type="button" class="pd2-play-btn pd2-play-btn--static" id="{{ $playButtonId }}"
                aria-label="{{ __('Play video') }}">
                Play
            </button>
        </div>
    </section>
@endif
