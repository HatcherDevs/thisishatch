@php
    $projectImage = $project->image ?: $project->cover;

    $projectImageUrl = $projectImage
        ? RvMedia::getImageUrl($projectImage)
        : Theme::asset()->url('imgs/projects/project-details/details.png');

    $projectTitle = $project->title ?? '';

    $projectYear = $project->year ?? '';

    $projectTagline = $project->tagline ?? '';

    $projectDescription = $project->description ?? '';

    $projectContent = $project->content ?? '';

    $projectTags = $project->tags ?? collect();

    $projectCategory = $project->category ?? null;

    // -----------
    $projectVideos = $project->videos ?? [];

    if (is_string($projectVideos)) {
        $projectVideos = json_decode($projectVideos, true);
    }

    if (!is_array($projectVideos)) {
        $projectVideos = [];
    }

    $projectVideos = collect($projectVideos)
        ->filter(function ($video) {
            return is_array($video) && !empty($video['url']);
        })
        ->values();

    $firstVideo = $projectVideos->first();

    $videoUrl = $firstVideo['url'] ?? null;
    $videoCover = $firstVideo['cover'] ?? null;

    $videoCoverUrl = $videoCover ? RvMedia::getImageUrl($videoCover) : Theme::asset()->url('imgs/timeline-video.png');

    $youtubeId = null;
    $vimeoId = null;

    if ($videoUrl) {
        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $videoUrl, $matches)) {
            $youtubeId = $matches[1];
        } elseif (preg_match('/vimeo\.com\/(\d+)/', $videoUrl, $matches)) {
            $vimeoId = $matches[1];
        }
    }

    $isExternalVideo = $youtubeId || $vimeoId;

    // ---------------------
    $galleryImages = $project->gallery_images ?? [];

    if (is_string($galleryImages)) {
        $galleryImages = json_decode($galleryImages, true);
    }

    if (!is_array($galleryImages)) {
        $galleryImages = [];
    }

    $galleryImages = array_values(array_filter($galleryImages));
    $galleryCount = count($galleryImages);

    // dd($project,$projectVideos,$videoUrl,$youtubeId,$vimeoId);

@endphp
<div class="container w-md-75">
    <section class="pd2-hero">
        <img class="pd2-hero-img img-fluid" src="{{ $projectImageUrl }}" alt="{{ $projectTitle }}" />

        <div class="row pt-2 pd2-meta">
            <div class="col-6">
                @if ($projectYear)
                    <span class="pd2-year">
                        {{ $projectYear }}
                    </span>
                @endif
            </div>

            <div class="col-6 pd2-tags">
                @if ($projectCategory)
                    <a href="{{ $projectCategory->url ?? '#' }}">
                        {{ $projectCategory->name }}
                    </a>
                @endif

                @if ($projectCategory && $projectTags->isNotEmpty())
                    |
                @endif

                @foreach ($projectTags as $tag)
                    <a href="{{ $tag->url ?? '#' }}">
                        {{ $tag->name }}
                    </a>

                    @if (!$loop->last)
                        |
                    @endif
                @endforeach
            </div>
        </div>
    </section>

    <section class="pd2-intro">
        <h1 class="pd2-title pt-5 pb-3 fw-light">
            {{ $projectTitle }}
        </h1>

        @if ($projectTagline)
            <p class="pd2-lead fw-bold pb-5 w-75">
                {{ $projectTagline }}
            </p>
        @endif

        @if ($projectDescription)
            <div class="w-100 d-flex justify-content-end">
                <div class="pd2-body w-75">
                    {!! BaseHelper::clean($projectDescription) !!}
                </div>
            </div>
        @endif

        @if ($projectContent)
            <div class="w-100 d-flex justify-content-end">
                <div class="pd2-body w-75">
                    {!! BaseHelper::clean($projectContent) !!}
                </div>
            </div>
        @endif
    </section>

    @if ($videoUrl)
        <section class="pd2-video">
            <div class="pd2-video-wrap pd2-video-custom" id="pd2VideoCustom">

                @if ($youtubeId)
                    <iframe id="pd2Video" src="https://www.youtube.com/embed/{{ $youtubeId }}?enablejsapi=1&rel=0"
                        title="{{ $project->title }}" loading="lazy"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        allowfullscreen></iframe>
                @elseif ($vimeoId)
                    <iframe id="pd2Video" src="https://player.vimeo.com/video/{{ $vimeoId }}"
                        title="{{ $project->title }}" loading="lazy" allow="autoplay; fullscreen; picture-in-picture"
                        allowfullscreen></iframe>
                @else
                    <video id="pd2Video" poster="{{ $videoCoverUrl }}" preload="metadata" playsinline controls>
                        <source src="{{ $videoUrl }}" type="video/mp4">
                    </video>
                @endif

                @if ($videoCoverUrl)
                    <div class="pd2-video-cover" id="pd2VideoCover"
                        style="background-image: url('{{ $videoCoverUrl }}');">
                        <button type="button" class="pd2-play-btn pd2-play-btn--static" id="pd2PlayBtn"
                            aria-label="{{ __('Play video') }}">
                            Play
                        </button>
                    </div>
                @endif

            </div>
        </section>

        <style>
            .pd2-video-wrap {
                position: relative;
                width: 100%;
                min-height: 300px;
                aspect-ratio: 16 / 9;
                overflow: hidden;
                background: #000;
            }

            .pd2-video-wrap video,
            .pd2-video-wrap iframe {
                position: absolute;
                inset: 0;
                display: block;
                width: 100%;
                height: 100%;
                min-height: 300px;
                border: 0;
                object-fit: cover;
                background: #000;
            }

            .pd2-video-cover {
                position: absolute;
                inset: 0;
                z-index: 5;
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                height: 100%;
                background-color: #000;
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
                opacity: 1;
                visibility: visible;
                transition: opacity 0.3s ease, visibility 0.3s ease;
            }

            .pd2-video-cover::before {
                position: absolute;
                inset: 0;
                z-index: 0;
                background: rgba(0, 0, 0, 0.25);
                content: "";
            }

            .pd2-video-cover.is-hidden {
                visibility: hidden;
                opacity: 0;
                pointer-events: none;
            }

            .pd2-video-cover .pd2-play-btn {
                position: relative;
                z-index: 1;
                cursor: pointer;
            }
        </style>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const wrapper = document.getElementById('pd2VideoCustom');
                const cover = document.getElementById('pd2VideoCover');
                const playButton = document.getElementById('pd2PlayBtn');
                const media = document.getElementById('pd2Video');

                if (!wrapper || !cover || !playButton || !media) {
                    return;
                }

                playButton.addEventListener('click', function(event) {
                    event.preventDefault();
                    event.stopPropagation();

                    cover.classList.add('is-hidden');

                    if (media.tagName.toLowerCase() === 'video') {
                        media.play().catch(function(error) {
                            console.warn('Video playback failed:', error);
                        });

                        return;
                    }

                    if (media.tagName.toLowerCase() === 'iframe') {
                        const currentSrc = media.getAttribute('src');

                        if (currentSrc && !currentSrc.includes('autoplay=1')) {
                            const separator = currentSrc.includes('?') ? '&' : '?';

                            media.setAttribute(
                                'src',
                                currentSrc + separator + 'autoplay=1'
                            );
                        }
                    }
                });
            });
        </script>

    @endif

    @if ($galleryCount === 1)
        <section class="pd2-fullimg">
            <img src="{{ RvMedia::getImageUrl($galleryImages[0]) }}" alt="{{ $project->title }}" />
        </section>
    @elseif ($galleryCount === 2)
        <section class="pd2-grid pd2-grid--2">
            @foreach ($galleryImages as $image)
                <img src="{{ RvMedia::getImageUrl($image) }}" alt="{{ $project->title }} - {{ $loop->iteration }}" />
            @endforeach
        </section>
    @elseif ($galleryCount === 3)
        <section class="pd2-grid pd2-grid--3">
            @foreach ($galleryImages as $image)
                <img src="{{ RvMedia::getImageUrl($image) }}" alt="{{ $project->title }} - {{ $loop->iteration }}" />
            @endforeach
        </section>
    @elseif ($galleryCount > 3)
        <section class="pd2-grid pd2-grid--2 pd2-grid--stagger">
            @foreach ($galleryImages as $image)
                <img class="{{ $loop->odd ? 'pd2-stagger-left' : 'pd2-stagger-right' }}"
                    src="{{ RvMedia::getImageUrl($image) }}" alt="{{ $project->title }} - {{ $loop->iteration }}" />
            @endforeach
        </section>
    @endif



    @if ($previousProject || $nextProject)
        <section class="pd2-slider" data-parallax-trigger>
            <nav class="pd2-project-nav" aria-label="{{ __('Project navigation') }}">
                <button type="button"
                    class="pd2-nav-prev pd2-swiper-prev{{ $previousProject ? '' : ' swiper-button-disabled' }}"
                    aria-label="{{ __('Previous project') }}"
                    @if ($previousProject) data-url="{{ $previousProject->url }}"
            @else
                disabled
                aria-disabled="true" @endif>
                    <img class="pd2-nav-arrow" src="{{ Theme::asset()->url('imgs/projects/pd2-arrow.png') }}"
                        alt="" />

                    <span>
                        {{ __('Previous') }}
                    </span>
                </button>

                <button type="button"
                    class="pd2-nav-next pd2-swiper-next{{ $nextProject ? '' : ' swiper-button-disabled' }}"
                    aria-label="{{ __('Next project') }}"
                    @if ($nextProject) data-url="{{ $nextProject->url }}"
            @else
                disabled
                aria-disabled="true" @endif>
                    <img class="pd2-nav-arrow" src="{{ Theme::asset()->url('imgs/projects/pd2-arrow.png') }}"
                        alt="" />

                    <span>
                        {{ __('Next') }}
                    </span>
                </button>
            </nav>
        </section>
    @endif

    {{-- <div class="pb-5 mb-5"></div> --}}


</div>
