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
                <button type="button" class="pd2-play-btn pd2-play-btn--static" id="pd2PlayBtn" aria-hidden="true">
                    Play
                </button>

                @if ($videoCoverUrl)
                    <div class="pd2-video-cover" id="pd2VideoCover"
                        style="background-image: url('{{ $videoCoverUrl }}');">

                    </div>
                @endif

            </div>
        </section>



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




</div>
