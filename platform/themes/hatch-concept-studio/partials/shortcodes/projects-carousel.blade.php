@php
    if (!isset($projects)) {
        $projects = \Botble\Projects\Models\Project::query()
            ->where('status', \Botble\Base\Enums\BaseStatusEnum::PUBLISHED)
            ->where('highlight', true)
            ->latest('id')
            ->limit(8)
            ->get();
    }

    $getImage = function ($project) {
        $image = $project->image ?: $project->cover;

        return $image ? RvMedia::getImageUrl($image) : Theme::asset()->url('imgs/timeline-video.png');
    };

    $getDescription = function ($project) {
        if ($project->relationLoaded('category') && $project->category) {
            return $project->category->name;
        }

        return $project->tagline;
    };

    $p0 = $projects->get(0);
    $p1 = $projects->get(1);
    $p2 = $projects->get(2);
    $p3 = $projects->get(3);
    $p4 = $projects->get(4);
    $p5 = $projects->get(5);
@endphp


@if ($projects->isNotEmpty())
    <section id="page3" class="home-portfolio-section">
        <div class="home-portfolio-inner">

            @if ($p0 || $p1)
                <div class="portfolio-block-group portfolio-block-group-hero">

                    @if ($p0)
                        <div class="portfolio-block portfolio-block-1">
                            <div class="portfolio-block-inner">
                                <article class="portfolio-item item-nothing">
                                    <a href="{{ $p0->url }}" class="portfolio-media portfolio-media--nothing">
                                        <img src="{{ $getImage($p0) }}" alt="{{ $p0->title }}" loading="lazy" />
                                    </a>

                                    <div class="portfolio-caption">
                                        <h3>{{ $p0->title }}</h3>

                                        @if ($getDescription($p0))
                                            <p>{{ $getDescription($p0) }}</p>
                                        @endif
                                    </div>
                                </article>
                            </div>
                        </div>
                    @endif

                    @if ($p1)
                        <div class="portfolio-hero-right">
                            <div class="portfolio-hero-deco-box">
                                <img class="portfolio-deco deco-speech"
                                    src="{{ Theme::asset()->url('imgs/click_graphics/text.png') }}" alt=""
                                    aria-hidden="true" />
                            </div>

                            <div class="portfolio-block portfolio-block-2">
                                <article class="portfolio-item item-jotun">
                                    <a href="{{ $p1->url }}" class="portfolio-media">
                                        <img src="{{ $getImage($p1) }}" alt="{{ $p1->title }}" loading="lazy" />
                                    </a>

                                    <div class="portfolio-caption">
                                        <h3>{{ $p1->title }}</h3>

                                        @if ($getDescription($p1))
                                            <p>{{ $getDescription($p1) }}</p>
                                        @endif
                                    </div>
                                </article>
                            </div>
                        </div>
                    @endif

                </div>
            @endif

            @if ($p2 || $p3)
                <div class="portfolio-block portfolio-block-3">
                    <div class="portfolio-block-inner">

                        @if ($p2)
                            <article class="portfolio-item item-shelf">
                                <a href="{{ $p2->url }}" class="portfolio-media">
                                    <img src="{{ $getImage($p2) }}" alt="{{ $p2->title }}" loading="lazy" />
                                </a>

                                <div class="portfolio-caption">
                                    <h3>{{ $p2->title }}</h3>

                                    @if ($getDescription($p2))
                                        <p>{{ $getDescription($p2) }}</p>
                                    @endif
                                </div>
                            </article>
                        @endif

                        @if ($p3)
                            <article class="portfolio-item item-guided-kids">
                                <a href="{{ $p3->url }}" class="portfolio-media">
                                    <img src="{{ $getImage($p3) }}" alt="{{ $p3->title }}" loading="lazy" />
                                </a>

                                <div class="portfolio-caption">
                                    <h3>{{ $p3->title }}</h3>

                                    @if ($getDescription($p3))
                                        <p>{{ $getDescription($p3) }}</p>
                                    @endif
                                </div>
                            </article>
                        @endif

                    </div>
                </div>
            @endif

            @if ($p4 || $p5)
                <div class="portfolio-block portfolio-block-4">
                    <div class="portfolio-block-inner">

                        @if ($p4)
                            <article class="portfolio-item item-guided-gradient">
                                <div class="portfolio-deco-arrow-wrap">
                                    <img class="portfolio-deco deco-arrow"
                                        src="{{ Theme::asset()->url('imgs/click_graphics/arrow-3d.png') }}"
                                        alt="" aria-hidden="true" />
                                </div>

                                <a href="{{ $p4->url }}" class="portfolio-media">
                                    <img src="{{ $getImage($p4) }}" alt="{{ $p4->title }}" loading="lazy" />
                                </a>

                                <div class="portfolio-caption">
                                    <h3>{{ $p4->title }}</h3>

                                    @if ($getDescription($p4))
                                        <p>{{ $getDescription($p4) }}</p>
                                    @endif
                                </div>

                                <div class="portfolio-deco-at-wrap">
                                    <img class="portfolio-deco deco-at"
                                        src="{{ Theme::asset()->url('imgs/click_graphics/at.png') }}" alt=""
                                        aria-hidden="true" />
                                </div>
                            </article>
                        @endif

                        @if ($p5)
                            <div class="portfolio-amazon-column">
                                <div class="portfolio-deco-hashtag-wrap">
                                    <img class="portfolio-deco deco-hashtag"
                                        src="{{ Theme::asset()->url('imgs/click_graphics/hashtah.png') }}"
                                        alt="" aria-hidden="true" />
                                </div>

                                <article class="portfolio-item item-guided-amazon">
                                    <a href="{{ $p5->url }}" class="portfolio-media">
                                        <img src="{{ $getImage($p5) }}" alt="{{ $p5->title }}" loading="lazy" />
                                    </a>

                                    <div class="portfolio-caption">
                                        <h3>{{ $p5->title }}</h3>

                                        @if ($getDescription($p5))
                                            <p>{{ $getDescription($p5) }}</p>
                                        @endif
                                    </div>
                                </article>
                            </div>
                        @endif

                    </div>
                </div>
            @endif
            <div class="home-about-strip">
                <div class="home-about-copy">
                    <p>
                        {{ $shortcode->left_description ??
                            ', and experiences across the UAE and GCC. Blending strategy, design, and storytelling, we craft work that connects with audiences, delivers results, and stands apart.' }}
                    </p>
                </div>

                <div class="home-about-headline">
                    @php
                        $headlineText = $shortcode->right_title ?? 'One team. Many creative muscles.';

                        $rawLines = explode('.', trim($headlineText));

                        $headlineLines = [];

                        foreach ($rawLines as $line) {
                            $line = trim($line);

                            if ($line !== '') {
                                $headlineLines[] = $line . '.';
                            }
                        }
                    @endphp

                    @foreach ($headlineLines as $index => $line)
                        <span class="line line-{{ $index + 1 }}">
                            {{ $line }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
@endif
