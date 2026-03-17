

{{-- Layout for single repository page --}}
@extends('theme.sharjah-triennial::layouts.master')

@section('content')
    <main id="main-content" class="main-content event-section about_page">
        <section class="row mb-5">
            @if ($opportunity && $opportunity->image)
                <div class="col-12 header_img">
                    <img class="border-top border-3 border-black"
                        src="{{ RvMedia::getImageUrl($opportunity->image, null, false, RvMedia::getDefaultImage()) }}"
                        alt="{{ $opportunity->title }}" style="width: 100%; height: 100%; object-fit: cover; display: block" />
                </div>
            @endif

            <div class="col-12">
                <hr class="divider" />
                <h2 class="my-1" style="font-size: 26px">{{ $opportunity->title }}</h2>
                <hr class="divider" />
                <div class="row">
                    <div class="col-lg-5 mb-4 mb-lg-0">

                    </div>
                    <div class="col-lg-7">
                        <div class="desc pt-md-4 mt-3 fs-5">
                            {!! $opportunity->content !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection
