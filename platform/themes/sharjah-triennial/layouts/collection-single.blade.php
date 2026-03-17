{{-- Layout for single collection page --}}
@extends('theme.sharjah-triennial::layouts.master')

@section('content')
<main id="main-content" class="main-content event-section about_page">
    <section class="row mb-5">
        @if($collection && $collection->image)
            <div class="col-12 header_img">
                <img class="border-top border-3 border-black"
                    src="{{ RvMedia::getImageUrl($collection->image, null, false, RvMedia::getDefaultImage()) }}"
                    alt="{{ $collection->name }}"
                    style="width: 100%; height: 100%; object-fit: cover; display: block" />
            </div>
        @endif

        <div class="col-12">
            <hr class="divider" />
            <h2 class="my-1" style="font-size: 26px">{{ $collection->name }}</h2>
            <hr class="divider" />
            <div class="row">
                <div class="col-lg-5 mb-4 mb-lg-0">
                    @if($collection->description)
                        <div class="desc pt-md-4 mt-3 fs-5">
                            {!! BaseHelper::clean($collection->description) !!}
                        </div>
                    @endif
                </div>
                <div class="col-lg-7">
                    @if(isset($products) && $products->count() > 0)
                        <div class="products-list pt-md-4 mt-3">
                            <h3 class="mb-4">{{ __('Products') }}</h3>
                            <div class="row">
                                @foreach($products as $product)
                                    <div class="col-md-6 mb-4">
                                        <div class="product-card">
                                            @if($product->image)
                                                <a
                                                    href="{{ route('store.product.single', $product->slug) }}">
                                                    <img src="{{ RvMedia::getImageUrl($product->image, 'medium', false, RvMedia::getDefaultImage()) }}"
                                                        alt="{{ $product->name }}" class="img-fluid mb-3" />
                                                </a>
                                            @endif
                                            <h4>
                                                <a
                                                    href="{{ route('store.product.single', $product->slug) }}">
                                                    {{ $product->name }}
                                                </a>
                                            </h4>
                                            @if($product->description)
                                                <p>{{ Str::limit(strip_tags($product->description), 150) }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
