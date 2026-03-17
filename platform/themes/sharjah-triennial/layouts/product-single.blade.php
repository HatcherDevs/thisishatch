{{-- Layout for single product page --}}
@extends('theme.sharjah-triennial::layouts.master')

@section('content')
<main id="main-content" class="main-content event-section about_page">
    <section class="row mb-5">
        @if($product && $product->image)
            <div class="col-12 header_img">
                <img class="border-top border-3 border-black"
                    src="{{ RvMedia::getImageUrl($product->image, null, false, RvMedia::getDefaultImage()) }}"
                    alt="{{ $product->name }}" style="width: 100%; height: 100%; object-fit: cover; display: block" />
            </div>
        @endif

        <div class="col-12">
            <hr class="divider" />
            <h2 class="my-1" style="font-size: 26px">{{ $product->name }}</h2>
            @if($product->collection)
                <p class="text-muted">
                    <a
                        href="{{ route('store.collection.single', $product->collection->slug) }}">
                        {{ $product->collection->name }}
                    </a>
                </p>
            @endif
            <hr class="divider" />
            <div class="row">
                <div class="col-lg-5 mb-4 mb-lg-0">
                    @if($product->description)
                        <div class="desc pt-md-4 mt-3 fs-5">
                            {!! BaseHelper::clean($product->description) !!}
                        </div>
                    @endif
                </div>
                <div class="col-lg-7">
                    @if($product->content)
                        <div class="desc pt-md-4 mt-3 fs-5 ck-content">
                            {!! BaseHelper::clean($product->content) !!}
                        </div>
                    @endif

                    @if($product->down_row)
                        <div class="desc mt-4 fs-5 ck-content">
                            {!! BaseHelper::clean($product->down_row) !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
