<!-- Page Header -->
{{-- <section class="page-header bg-light py-5">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h1 class="page-title display-4 fw-bold mb-3">{{ $page->name }}</h1>
                @if($page->description)
                <p class="lead text-muted">{{ $page->description }}</p>
                @endif
            </div>
        </div>
    </div>
</section> --}}

<!-- Page Content -->
{{-- <section class="page-content-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="content-wrapper"> --}}

 
                    {!! apply_filters(PAGE_FILTER_FRONT_PAGE_CONTENT, Html::tag('div', $page->content, ['class' => 'ck-content'])->toHtml(), $page) !!}
                {{-- </div>
            </div>
        </div>
    </div> --}}
{{-- </section> --}}