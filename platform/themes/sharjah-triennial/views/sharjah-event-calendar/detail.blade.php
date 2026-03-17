@extends('theme.sharjah-triennial::layouts.default')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h1>{{ $pageData->name }}</h1>
                <p class="lead">{{ $pageData->description }}</p>

                @if($pageData->image)
                    <img src="{{ RvMedia::getImageUrl($pageData->image) }}" alt="{{ $pageData->name }}" class="img-fluid mb-4">
                @endif

                <div class="card">
                    <div class="card-body">
                        <p><strong>Start Date:</strong> {{ $pageData->start_date }}</p>
                        @if($pageData->content)
                            <div class="mt-4">
                                {!! BaseHelper::clean($pageData->content) !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection