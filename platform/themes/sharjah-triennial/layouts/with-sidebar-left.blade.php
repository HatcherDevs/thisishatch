@extends('theme.sharjah-triennial::layouts.master')

@section('page')
    {!! Theme::partial('header') !!}

    {{-- {!! Theme::partial('breadcrumb') !!} --}}

    <!-- Main Content with Left Sidebar -->
    <main id="main-content" class="page-content">
        <div class="container py-5">
            <div class="row">
                <!-- Sidebar Left -->
                <aside class="col-lg-3 col-md-4 mb-4 mb-md-0" data-aos="fade-right">
                    <div class="sidebar sticky-top" style="top: 100px;">
                        {!! dynamic_sidebar('primary_sidebar') !!}
                    </div>
                </aside>

                <!-- Content -->
                <div class="col-lg-9 col-md-8" data-aos="fade-left">
                    @if (Theme::get('hasBreadcrumb', true))
                        <div class="page-header mb-4">
                            <h1 class="page-title mb-3">{{ $page->name }}</h1>
                            @if ($page->description)
                                <p class="page-description text-muted">{{ $page->description }}</p>
                            @endif
                        </div>
                    @endif

                    <div class="page-body">
                        {!! Theme::content() !!}
                    </div>
                </div>
            </div>
        </div>
    </main>

    {!! Theme::partial('footer') !!}
@endsection