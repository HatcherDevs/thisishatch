@php
    use Botble\Base\Enums\BaseStatusEnum;
    use Botble\Projects\Models\Project;

    if (! isset($projects)) {
        $projects = Project::query()
            ->with(['category', 'tags'])
            ->where('status', BaseStatusEnum::PUBLISHED)
            ->where('highlight', true)
            ->orderBy('order')
            ->orderByDesc('id')
            ->limit(6)
            ->get();
    }

    $getProjectImage = function (Project $project): string {
        $image = $project->image ?: $project->cover;

        return $image
            ? RvMedia::getImageUrl($image)
            : Theme::asset()->url('imgs/timeline-video.png');
    };

    $getProjectDescription = function (Project $project): ?string {
        if ($project->relationLoaded('category') && $project->category) {
            return $project->category->name;
        }

        return $project->tagline;
    };

    $getGalleryImages = function (Project $project): array {
        $images = $project->gallery_images ?? [];

        if (is_string($images)) {
            $images = json_decode($images, true);
        }

        return is_array($images)
            ? array_values(array_filter($images))
            : [];
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

            {{-- Project 1: Nothing --}}
            @if ($p0 || $p1)
                <div class="portfolio-block-group portfolio-block-group-hero">

                    @if ($p0)
                        @php
                            $p0Gallery = $getGalleryImages($p0);
                        @endphp

                        <div class="portfolio-block portfolio-block-1">
                            <div class="portfolio-block-inner">
                                <article class="portfolio-item item-nothing">
                                    <a
                                        href="{{ $p0->url }}"
                                        class="portfolio-media portfolio-media--nothing"
                                    >
                                        @if (count($p0Gallery) >= 3)
                                            @foreach (array_slice($p0Gallery, 0, 3) as $index => $image)
                                                <img
                                                    src="{{ RvMedia::getImageUrl($image) }}"
                                                    alt="{{ $p0->title }} - {{ $index + 1 }}"
                                                    loading="{{ $index === 0 ? 'eager' : 'lazy' }}"
                                                >
                                            @endforeach
                                        @else
                                            <img
                                                src="{{ $getProjectImage($p0) }}"
                                                alt="{{ $p0->title }}"
                                                loading="eager"
                                            >
                                        @endif
                                    </a>

                                    <div class="portfolio-caption">
                                        <h3>{{ $p0->title }}</h3>

                                        @if ($getProjectDescription($p0))
                                            <p>
                                                {{ $getProjectDescription($p0) }}
                                            </p>
                                        @endif
                                    </div>
                                </article>
                            </div>
                        </div>
                    @endif

                    @if ($p1)
                        <div class="portfolio-hero-right">
                            <div class="portfolio-hero-deco-box">
                                <img
                                    class="portfolio-deco deco-speech"
                                    src="{{ Theme::asset()->url('imgs/click_graphics/text.png') }}"
                                    alt=""
                                    aria-hidden="true"
                                >
                            </div>

                            <div class="portfolio-block portfolio-block-2">
                                <article class="portfolio-item item-jotun">
                                    <a
                                        href="{{ $p1->url }}"
                                        class="portfolio-media"
                                    >
                                        <img
                                            src="{{ $getProjectImage($p1) }}"
                                            alt="{{ $p1->title }}"
                                            loading="lazy"
                                        >
                                    </a>

                                    <div class="portfolio-caption">
                                        <h3>{{ $p1->title }}</h3>

                                        @if ($getProjectDescription($p1))
                                            <p>
                                                {{ $getProjectDescription($p1) }}
                                            </p>
                                        @endif
                                    </div>
                                </article>
                            </div>
                        </div>
                    @endif

                </div>
            @endif

            {{-- Projects 3 and 4 --}}
            @if ($p2 || $p3)
                <div class="portfolio-block portfolio-block-3">
                    <div class="portfolio-block-inner">

                        @if ($p2)
                            <article class="portfolio-item item-shelf">
                                <a
                                    href="{{ $p2->url }}"
                                    class="portfolio-media"
                                >
                                    <img
                                        src="{{ $getProjectImage($p2) }}"
                                        alt="{{ $p2->title }}"
                                        loading="lazy"
                                    >
                                </a>

                                <div class="portfolio-caption">
                                    <h3>{{ $p2->title }}</h3>

                                    @if ($getProjectDescription($p2))
                                        <p>
                                            {{ $getProjectDescription($p2) }}
                                        </p>
                                    @endif
                                </div>
                            </article>
                        @endif

                        @if ($p3)
                            <article class="portfolio-item item-guided-kids">
                                <a
                                    href="{{ $p3->url }}"
                                    class="portfolio-media"
                                >
                                    <img
                                        src="{{ $getProjectImage($p3) }}"
                                        alt="{{ $p3->title }}"
                                        loading="lazy"
                                    >
                                </a>

                                <div class="portfolio-caption">
                                    <h3>{{ $p3->title }}</h3>

                                    @if ($getProjectDescription($p3))
                                        <p>
                                            {{ $getProjectDescription($p3) }}
                                        </p>
                                    @endif
                                </div>
                            </article>
                        @endif

                    </div>
                </div>
            @endif

            {{-- Projects 5 and 6 --}}
            @if ($p4 || $p5)
                <div class="portfolio-block portfolio-block-4">
                    <div class="portfolio-block-inner">

                        @if ($p4)
                            <article class="portfolio-item item-guided-gradient">
                                <div class="portfolio-deco-arrow-wrap">
                                    <img
                                        class="portfolio-deco deco-arrow"
                                        src="{{ Theme::asset()->url('imgs/home/arrow-3d.png') }}"
                                        alt=""
                                        aria-hidden="true"
                                    >
                                </div>

                                <a
                                    href="{{ $p4->url }}"
                                    class="portfolio-media"
                                >
                                    <img
                                        src="{{ $getProjectImage($p4) }}"
                                        alt="{{ $p4->title }}"
                                        loading="lazy"
                                    >
                                </a>

                                <div class="portfolio-caption">
                                    <h3>{{ $p4->title }}</h3>

                                    @if ($getProjectDescription($p4))
                                        <p>
                                            {{ $getProjectDescription($p4) }}
                                        </p>
                                    @endif
                                </div>

                                <div class="portfolio-deco-at-wrap">
                                    <img
                                        class="portfolio-deco deco-at"
                                        src="{{ Theme::asset()->url('imgs/home/at.png') }}"
                                        alt=""
                                        aria-hidden="true"
                                    >
                                </div>
                            </article>
                        @endif

                        @if ($p5)
                            <div class="portfolio-amazon-column">
                                <div class="portfolio-deco-hashtag-wrap">
                                    <img
                                        class="portfolio-deco deco-hashtag"
                                        src="{{ Theme::asset()->url('imgs/home/hashtag.png') }}"
                                        alt=""
                                        aria-hidden="true"
                                    >
                                </div>

                                <article class="portfolio-item item-guided-amazon">
                                    <a
                                        href="{{ $p5->url }}"
                                        class="portfolio-media"
                                    >
                                        <img
                                            src="{{ $getProjectImage($p5) }}"
                                            alt="{{ $p5->title }}"
                                            loading="lazy"
                                        >
                                    </a>

                                    <div class="portfolio-caption">
                                        <h3>{{ $p5->title }}</h3>

                                        @if ($getProjectDescription($p5))
                                            <p>
                                                {{ $getProjectDescription($p5) }}
                                            </p>
                                        @endif
                                    </div>
                                </article>
                            </div>
                        @endif

                    </div>
                </div>
            @endif

            {{-- About strip --}}
            <div class="home-about-strip">
                <div class="home-about-copy">
                    <p>
                        {{ $shortcode->left_description ?? 'Since 2013, Hatch Concept Studio has been creating bold brands, campaigns, and experiences across the UAE and GCC. Blending strategy, design, and storytelling, we craft work that connects with audiences, delivers results, and stands apart.' }}
                    </p>
                </div>

                <div class="home-about-headline">
                    @php
                        $headlineText = $shortcode->right_title ?? 'One team. Many creative muscles.';

                        $headlineLines = collect(explode('.', trim($headlineText)))
                            ->map(fn ($line) => trim($line))
                            ->filter()
                            ->values();
                    @endphp

                    @foreach ($headlineLines as $index => $line)
                        <span class="line line-{{ $index + 1 }}">
                            {{ $line }}.
                        </span>
                    @endforeach
                </div>
            </div>

        </div>
    </section>
@endif