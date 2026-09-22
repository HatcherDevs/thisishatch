@php
    use Botble\Testimonial\Models\Testimonial as TestimonialModel;
    use Botble\Base\Enums\BaseStatusEnum;

    $testimonials = TestimonialModel::query()
        ->where('status', BaseStatusEnum::PUBLISHED)
        ->latest('id')
        ->limit(8)
        ->get();


       $minSlidesForLoop = 6;

    if ($testimonials->count() > 0 && $testimonials->count() < $minSlidesForLoop) {
        $repeated = collect();

        while ($repeated->count() < $minSlidesForLoop) {
            $repeated = $repeated->merge($testimonials);
        }

        $testimonials = $repeated->take($minSlidesForLoop);
    }




@endphp

@if ($testimonials->isNotEmpty())
<link rel="stylesheet" href="{{ asset('themes/hatch-concept-studio/css/home-sections.css') }}">

    <section
        class="home-testimonials-section"
        aria-label="Client testimonials"
    >
        <div class="home-testimonials-inner">
            <header class="home-testimonials-header">
                <h2>{{ $shortcode->title ?? 'Why our clients choose us' }}</h2>

                <p>
                    {!!
                        $shortcode->description
                        ?? '13 years. Countless success stories. Built together with clients<br>who trusted us every step of the way.'
                    !!}
                </p>
            </header>
        </div>

        <div class="home-testimonials-slider-wrap">
            <div class="swiper home-testimonials-swiper">
                <div class="swiper-wrapper">

                    @foreach ($testimonials as $testimonial)
                        @php
                            $testimonialContent = $testimonial->content
                                ?? $testimonial->description
                                ?? '';

                            $testimonialName = $testimonial->name ?? '';

                            $testimonialCompany = $testimonial->address
                                ?? $testimonial->company
                                ?? $testimonial->position
                                ?? '';
                        @endphp

                        <article class="swiper-slide home-testimonial-card">
                            <blockquote class="home-testimonial-quote">
                                <p>
                                    &ldquo;{{ $testimonialContent }}&rdquo;
                                </p>
                            </blockquote>

                            <footer class="home-testimonial-meta">
                                @if ($testimonialName)
                                    <cite class="home-testimonial-name">
                                        {{ $testimonialName }}
                                    </cite>
                                @endif

                                @if ($testimonialCompany)
                                    <span class="home-testimonial-company">
                                        {{ $testimonialCompany }}
                                    </span>
                                @endif
                            </footer>
                        </article>
                    @endforeach

                </div>
            </div>

            <nav
                class="home-testimonials-nav"
                aria-label="Testimonials navigation"
            >
                <button
                    type="button"
                    class="home-testimonials-next"
                    aria-label="Next testimonial"
                >
                    <img
                        src="{{ Theme::asset()->url('imgs/projects/pd2-arrow.png') }}"
                        alt=""
                        aria-hidden="true"
                    />
                </button>
            </nav>
        </div>
    </section>
@endif