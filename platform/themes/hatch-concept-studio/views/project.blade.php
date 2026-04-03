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
                <div class="swiper-button-next">
                    Next
                    <i class="fa fa-arrow-right"></i>
                </div>
                <div class="swiper-button-prev">
                    <i class="fa fa-arrow-left"></i>
                    Previous
                </div>
            </div>
        </div>
    @endif
</div>



@if (!empty($relatedProjects) && $relatedProjects->isNotEmpty())





    <div id="page3" class="pb-5 mb-5">
        <div class="swiper-container">
            <div class="swiper-wrapper">
                @foreach ($relatedProjects as $project)
                    <div class="swiper-slide">
                        <a href="{{ $project->url }}" class="slide-inner">
                            <img src="{{ RvMedia::getImageUrl($project->cover ?: $project->image) }}"
                                alt="{{ $project->title }}" loading="lazy" />
                        </a>
                    </div>
                @endforeach
            </div>
            <!-- <div class="swiper-pagination"></div> -->
            <div class="swiper-button-next">
                Next Project
                <i class="fa fa-arrow-right"></i>
            </div>
            <div class="swiper-button-prev">
                <i class="fa fa-arrow-left"></i>
                Previous Project
            </div>
        </div>
    </div>

@endif








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
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
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
            navigation: {
                nextEl: '.other-projects-next',
                prevEl: '.other-projects-prev',
            },
        });
    }
</script>
