<div class="container w-md-75">
    <div>
        <img src="{{ RvMedia::getImageUrl($project->cover ?: $project->image) }}" class="img-fluid"
            alt="{{ $project->title }}" />

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

        @if ($project->description)
            <div class="w-100 d-flex justify-content-end pb-4">
                <div class="w-75">{!! BaseHelper::clean($project->description) !!}</div>
            </div>
        @endif

        @if ($project->content)
            <div class="project-content pb-5" style="padding-left: 24.8%;">
                {!! BaseHelper::clean(do_shortcode($project->content)) !!}
            </div>
        @endif

        @php
            $galleryImages = array_filter((array) $project->gallery_images);
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
    <div class="d-flex justify-content-between align-items-center pt-4 pb-5 mb-5">
        @if ($previousProject)
            <a href="{{ $previousProject->url }}" class="project-button-prev project-nav-prev"
                style="text-decoration: none;">
                <i class="fa fa-arrow-left"></i>
                Previous Project
            </a>
        @else
            <div></div>
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

<div class="pb-5 mb-5"></div>




<script>
    if (typeof Swiper !== 'undefined') {
        new Swiper('.mySwiper', {
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
