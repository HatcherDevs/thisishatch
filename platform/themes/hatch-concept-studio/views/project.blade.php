<div class="container w-md-75">
    <div>
        <img src="{{ RvMedia::getImageUrl($projectsPageCover ?: ($project->cover ?: $project->image)) }}"
            class="img-fluid" alt="{{ $project->title }}" />

        <div class="row pt-2">
            <div class="col-6">
                @if ($project->year)
                    <span style="color: #f8511e">{{ $project->year }}</span>
                @endif
            </div>
            <div class="col-6 text-end">
                @foreach ($project->tags as $tag)
                    @php
                        $tagLabel = trim((string) $tag->name);
                        $decodedTag = json_decode($tagLabel, true);

                        if (is_array($decodedTag)) {
                            $tagLabel = (string) ($decodedTag['value'] ?? ($decodedTag['name'] ?? $tagLabel));
                        } elseif (preg_match('/"value"\s*:\s*"([^"]+)"/', $tagLabel, $matches) === 1) {
                            $tagLabel = $matches[1];
                        }

                        $tagLabel = trim($tagLabel, " \t\n\r\0\x0B[]{}\"'");
                    @endphp

                    @if ($tagLabel !== '')
                        <span class="link-dark px-1 fw-bold">{{ $tagLabel }}</span>
                        @if (!$loop->last)
                            |
                        @endif
                    @endif
                @endforeach
            </div>
        </div>

        <h2 class="pt-5 pb-3 fw-light" style="color: #f8511e">{{ $project->title }}</h2>

        @if ($project->tagline)
            <p class="fw-bold pb-4 w-75">{{ $project->tagline }}</p>
        @endif

        @if ($project->content)
            <div class="project-content pb-5" style="padding-left: 24.8%;">
                {!! BaseHelper::clean(do_shortcode($project->content)) !!}
            </div>
        @endif

        @php
            $galleryImages = array_values(array_filter(array_unique(array_filter((array) $project->gallery_images))));
        @endphp
    </div>
</div>

@if (!empty($galleryImages))
    <div id="page3" class="pb-5 mb-5">
        <div class="swiper-container mySwiper pb-5 mb-5">
            <div class="swiper-wrapper">
                @foreach ($galleryImages as $image)
                    <div class="swiper-slide">
                        <a href="#" class="slide-inner" onclick="return false;">
                            <img src="{{ RvMedia::getImageUrl($image) }}" alt="{{ $project->title }}" />
                        </a>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
@endif




@if ($previousProject || $nextProject)
    <div class="d-flex justify-content-between align-items-center pt-4 pb-5 px-4 mb-5">
        @if ($previousProject)
            <a href="{{ $previousProject->url }}" class="project-button-prev project-nav-prev"
                style="text-decoration: none;">
                <i class="fa fa-arrow-left"></i>
                Previous Project
            </a>
        @else
        @endif

        @if ($nextProject)
            <a href="{{ $nextProject->url }}" class="project-button-next project-nav-next"
                style="text-decoration: none;">
                Next Project
                <i class="fa fa-arrow-right"></i>
            </a>
        @endif
    </div>
@endif

@php
    $projectVideos = array_filter((array) $project->videos, fn($v) => !empty($v['url']));
@endphp

@if (!empty($projectVideos))
    <div class="container w-md-75 pb-5 mb-5 p-md-5 position-relative">
        <div id="projectVideoCarousel" class="carousel slide" data-bs-ride="false" data-bs-interval="false">
            <div class="carousel-inner shadow-sm" style="border-radius: 8px; overflow: hidden;">
                @foreach (array_values($projectVideos) as $index => $video)
                    @php
                        $videoUrl = $video['url'];
                        $videoCover = $video['cover'] ?? null;

                        $embedUrl = null;
                        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $videoUrl, $m)) {
                            $embedUrl = 'https://www.youtube.com/embed/' . $m[1] . '?autoplay=1';
                        } elseif (preg_match('/vimeo\.com\/(\d+)/', $videoUrl, $m)) {
                            $embedUrl = 'https://player.vimeo.com/video/' . $m[1] . '?autoplay=1';
                        }
                    @endphp

                    @if ($embedUrl)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }} video-slide-item">
                            <div class="single-video-container position-relative overflow-hidden w-100 video-custom"
                                style="aspect-ratio: 16/9; background: #000; cursor: pointer;">
                                @if ($videoCover)
                                    <img src="{{ RvMedia::getImageUrl($videoCover) }}"
                                        class="w-100 h-100 object-fit-cover poster-img" alt="Video Cover">
                                @else
                                    <div
                                        class="w-100 h-100 d-flex align-items-center justify-content-center text-white">
                                        <span>Click to play</span>
                                    </div>
                                @endif
                                <div class="play-pause">
                                    <a class="play-btn btnVideo"><i></i></a>
                                </div>
                            </div>
                            <div class="single-video-iframe-container w-100 d-none"
                                style="aspect-ratio: 16/9; overflow: hidden;">
                                <iframe data-src="{{ $embedUrl }}" title="{{ $project->title }}"
                                    class="w-100 h-100 border-0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen>
                                </iframe>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>

            @if (count(array_filter((array) $projectVideos, fn($v) => !empty($v['url']))) > 1)
                <!-- Navigation -->
                <button class="carousel-control-prev" type="button" data-bs-target="#projectVideoCarousel"
                    data-bs-slide="prev" id="prevVideoSlideBtn">
                    <span class="carousel-control-prev-icon" aria-hidden="true"
                        style="background-color: rgba(0,0,0,0.5); border-radius: 50%; padding: 25px;"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#projectVideoCarousel"
                    data-bs-slide="next" id="nextVideoSlideBtn">
                    <span class="carousel-control-next-icon" aria-hidden="true"
                        style="background-color: rgba(0,0,0,0.5); border-radius: 50%; padding: 25px;"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            @endif
        </div>
    </div>

    <script data-cfasync="false">
        document.addEventListener('DOMContentLoaded', function() {
            var videoCarousel = document.getElementById('projectVideoCarousel');
            var carousel = null;

            if (videoCarousel) {
                // Initialize bootstrap carousel if it exists
                if (typeof bootstrap !== 'undefined' && bootstrap.Carousel) {
                    carousel = new bootstrap.Carousel(videoCarousel, {
                        interval: false,
                        wrap: true
                    });
                } else {
                    // Fallback vanilla JS sliding if Bootstrap JS is missing
                    let items = videoCarousel.querySelectorAll('.carousel-item');
                    let currentIndex = 0;
                    var nextVideoSlideBtn = document.getElementById('nextVideoSlideBtn');
                    var prevVideoSlideBtn = document.getElementById('prevVideoSlideBtn');

                    if (nextVideoSlideBtn) {
                        nextVideoSlideBtn.addEventListener('click', function() {
                            items[currentIndex].classList.remove('active');
                            currentIndex = (currentIndex + 1) % items.length;
                            items[currentIndex].classList.add('active');
                            stopAllIframes();
                        });
                    }

                    if (prevVideoSlideBtn) {
                        prevVideoSlideBtn.addEventListener('click', function() {
                            items[currentIndex].classList.remove('active');
                            currentIndex = (currentIndex - 1 + items.length) % items.length;
                            items[currentIndex].classList.add('active');
                            stopAllIframes();
                        });
                    }
                }

                videoCarousel.addEventListener('slide.bs.carousel', stopAllIframes);
            }

            function stopAllIframes() {
                document.querySelectorAll('.video-slide-item').forEach(function(item) {
                    var iframe = item.querySelector('iframe');
                    var container = item.querySelector('.single-video-container');
                    var iframeContainer = item.querySelector('.single-video-iframe-container');
                    if (iframe && iframe.src) {
                        iframe.src = '';
                        container.classList.remove('d-none');
                        iframeContainer.classList.add('d-none');
                    }
                });
            }

            document.querySelectorAll('.video-slide-item').forEach(function(item) {
                var container = item.querySelector('.single-video-container');
                var iframeContainer = item.querySelector('.single-video-iframe-container');
                var iframe = iframeContainer ? iframeContainer.querySelector('iframe') : null;

                if (container && iframeContainer && iframe) {
                    container.addEventListener('click', function() {
                        iframe.src = iframe.getAttribute('data-src');
                        container.classList.add('d-none');
                        iframeContainer.classList.remove('d-none');
                    });
                }
            });
        });
    </script>
@endif

<div class="pb-5 mb-5"></div>




<script data-cfasync="false">
    if (typeof Swiper !== 'undefined') {
        new Swiper('.mySwiper', {
            slidesPerView: 'auto',
            spaceBetween: 25,
            navigation: {
                nextEl: '.mySwiper .swiper-button-next',
                prevEl: '.mySwiper .swiper-button-prev',
            },
        });

        new Swiper('.otherProjectsSwiper', {
            slidesPerView: 3.4,
            spaceBetween: 25,
            breakpoints: {
                320: {
                    slidesPerView: 1.2
                },
                768: {
                    slidesPerView: 2.2
                },
                1024: {
                    slidesPerView: 3.4
                },
            },
        });

        document.querySelectorAll('.project-nav-next, .project-nav-prev').forEach(function(element) {
            element.addEventListener('click', function() {
                var targetUrl = element.getAttribute('data-url');
                if (targetUrl) {
                    window.location.href = targetUrl;
                }
            });

            element.addEventListener('keydown', function(event) {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    var targetUrl = element.getAttribute('data-url');
                    if (targetUrl) {
                        window.location.href = targetUrl;
                    }
                }
            });
        });
    }
</script>
