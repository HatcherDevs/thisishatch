@extends('theme.sharjah-triennial::layouts.master')

@section('content')
    @php
        $pageData = Theme::page();
    @endphp

    <main id="main-content" class="main-content father-template">
        {{-- Father Template Header Section --}}
        <section class="father-header-section">
            @if($pageData && $pageData->image)
                <div class="father-hero-image">
                    <img src="{{ RvMedia::getImageUrl($pageData->image, null, false, RvMedia::getDefaultImage()) }}"
                        alt="{{ $pageData->name }}" class="img-fluid w-100" style="height: 400px; object-fit: cover;" />
                </div>
            @endif

            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <div class="father-header-content py-5">
                            <h1 class="father-title display-4 fw-bold mb-4">
                                {{ $pageData->name ?? 'Father Template' }}
                            </h1>
                            @if($pageData && $pageData->description)
                                <p class="father-description lead text-muted mb-4">
                                    {{ $pageData->description }}
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Father Template Content Section --}}
        <section class="father-content-section py-5">
            <div class="container">
                <div class="row">
                    {{-- Main Content --}}
                    <div class="col-lg-8 mx-auto">
                        <div class="father-main-content">
                            <div class="content-wrapper bg-white p-4 rounded shadow-sm">
                                <div class="ck-content">
                                    {!! Theme::content() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Father Template Features Section --}}
        <section class="father-features-section py-5 bg-light">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center mb-5">
                        <h2 class="section-title h3 fw-bold">{{ __('Father Template Features') }}</h2>
                        <p class="text-muted">{{ __('Special features for this father template') }}</p>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="father-feature-card text-center p-4 bg-white rounded shadow-sm h-100">
                            <div class="feature-icon mb-3">
                                <i class="fas fa-heart text-primary fs-2"></i>
                            </div>
                            <h4 class="feature-title h5 fw-bold mb-3">{{ __('Love & Care') }}</h4>
                            <p class="feature-description text-muted">
                                {{ __('Dedicated to showing love and care for family members.') }}
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="father-feature-card text-center p-4 bg-white rounded shadow-sm h-100">
                            <div class="feature-icon mb-3">
                                <i class="fas fa-shield-alt text-success fs-2"></i>
                            </div>
                            <h4 class="feature-title h5 fw-bold mb-3">{{ __('Protection') }}</h4>
                            <p class="feature-description text-muted">
                                {{ __('Always ready to protect and support the family.') }}
                            </p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="father-feature-card text-center p-4 bg-white rounded shadow-sm h-100">
                            <div class="feature-icon mb-3">
                                <i class="fas fa-graduation-cap text-warning fs-2"></i>
                            </div>
                            <h4 class="feature-title h5 fw-bold mb-3">{{ __('Guidance') }}</h4>
                            <p class="feature-description text-muted">
                                {{ __('Providing wisdom and guidance for life decisions.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Father Template Call to Action --}}
        <section class="father-cta-section py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 mx-auto text-center">
                        <div class="father-cta-content">
                            <h3 class="cta-title h4 fw-bold mb-3">{{ __('Honor Your Father') }}</h3>
                            <p class="cta-description text-muted mb-4">
                                {{ __('Take a moment to appreciate and honor the father figure in your life.') }}
                            </p>
                            <div class="cta-buttons">
                                <a href="#" class="btn btn-primary btn-lg me-3">{{ __('Learn More') }}</a>
                                <a href="#" class="btn btn-outline-primary btn-lg">{{ __('Contact Us') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    {{-- Father Template Styles --}}
    @push('header')
        <style>
            .father-template {
                font-family: 'Inter', sans-serif;
            }

            .father-hero-image {
                position: relative;
                overflow: hidden;
            }

            .father-hero-image::after {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.3);
            }

            .father-header-content {
                position: relative;
                z-index: 2;
            }

            .father-title {
                color: #2c3e50;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            }

            .father-feature-card {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .father-feature-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
            }

            .feature-icon i {
                transition: transform 0.3s ease;
            }

            .father-feature-card:hover .feature-icon i {
                transform: scale(1.1);
            }

            .father-content-section .content-wrapper {
                border-top: 4px solid #3498db;
            }

            .father-cta-section {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                color: white;
            }

            .father-cta-section .cta-title,
            .father-cta-section .cta-description {
                color: white;
            }

            .father-cta-section .btn-primary {
                background-color: #fff;
                border-color: #fff;
                color: #667eea;
            }

            .father-cta-section .btn-primary:hover {
                background-color: #f8f9fa;
                border-color: #f8f9fa;
                color: #5a6fd8;
            }

            .father-cta-section .btn-outline-primary {
                border-color: #fff;
                color: #fff;
            }

            .father-cta-section .btn-outline-primary:hover {
                background-color: #fff;
                border-color: #fff;
                color: #667eea;
            }
        </style>
    @endpush
@endsection