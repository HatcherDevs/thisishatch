@extends('theme.sharjah-triennial::layouts.master')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section position-relative"
        style="min-height: 600px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-lg-8 mx-auto text-center text-white">
                    <h1 class="display-3 fw-bold mb-4" data-aos="fade-up">
                        {{ theme_option('site_title', 'Sharjah Architecture Triennial') }}
                    </h1>
                    <p class="lead mb-4" data-aos="fade-up" data-aos-delay="100">
                        {{ theme_option('site_description', 'A cultural platform celebrating architectural innovation and heritage') }}
                    </p>
                    <div class="hero-buttons" data-aos="fade-up" data-aos-delay="200">
                        <a href="#projects" class="btn btn-light btn-lg me-3">
                            <i class="fas fa-building me-2"></i>{{ __('Explore Projects') }}
                        </a>
                        <a href="#events" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-calendar me-2"></i>{{ __('View Events') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll Down Arrow -->
        <div class="scroll-down position-absolute bottom-0 start-50 translate-middle-x mb-4">
            <a href="#about" class="text-white">
                <i class="fas fa-chevron-down fa-2x animate-bounce"></i>
            </a>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="about-image mb-4 mb-lg-0">
                        <img src="{{ Theme::asset()->url('images/about-triennial.jpg') }}"
                            alt="{{ __('About Sharjah Architecture Triennial') }}" class="img-fluid rounded shadow-lg">
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left">
                    <div class="about-content ps-lg-4">
                        <h2 class="section-title mb-4">{{ __('About the Triennial') }}</h2>
                        <p class="lead text-muted mb-4">
                            The Sharjah Architecture Triennial is a pioneering cultural platform that brings together
                            architects,
                            designers, and thinkers from around the world to explore the future of architecture and
                            urbanism.
                        </p>
                        <p class="text-muted mb-4">
                            Through exhibitions, installations, workshops, and public programs, the Triennial fosters
                            dialogue
                            about pressing architectural and urban challenges, celebrating innovation while respecting
                            cultural heritage.
                        </p>
                        <a href="#" class="btn btn-primary">
                            {{ __('Learn More') }} <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section py-5 bg-dark text-white">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="0">
                    <div class="stat-item">
                        <div class="stat-number display-4 fw-bold mb-2">150+</div>
                        <div class="stat-label">{{ __('Projects') }}</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-item">
                        <div class="stat-number display-4 fw-bold mb-2">200+</div>
                        <div class="stat-label">{{ __('Architects') }}</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 mb-lg-0" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-item">
                        <div class="stat-number display-4 fw-bold mb-2">45+</div>
                        <div class="stat-label">{{ __('Countries') }}</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-item">
                        <div class="stat-number display-4 fw-bold mb-2">50K+</div>
                        <div class="stat-label">{{ __('Visitors') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    @if(is_plugin_active('newsletter'))
        <section class="newsletter-section py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center" data-aos="fade-up">
                        <h2 class="section-title mb-4">{{ __('Stay Updated') }}</h2>
                        <p class="lead text-muted mb-4">
                            {{ __('Subscribe to our newsletter for the latest updates on exhibitions, events, and architectural insights.') }}
                        </p>
                        <form class="newsletter-form row g-2 justify-content-center" method="POST"
                            action="{{ route('public.newsletter.subscribe') }}">
                            @csrf
                            <div class="col-md-6">
                                <input type="email" name="email" class="form-control form-control-lg"
                                    placeholder="{{ __('Enter your email') }}" required>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary btn-lg">{{ __('Subscribe') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection

@push('scripts')
    <!-- AOS Animation -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });
    </script>
@endpush