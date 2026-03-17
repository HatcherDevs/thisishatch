@extends('theme.sharjah-triennial::layouts.master')

@section('page')
    {!! Theme::partial('header') !!}

    {{-- {!! Theme::partial('breadcrumb') !!} --}}

    <!-- Main Content -->
    <main id="main-content" class="page-content">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-10">
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