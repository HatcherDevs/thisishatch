@extends('plugins.sharjah-event-calendar::layouts.public')

@section('title', __('Events in Category: :category', ['category' => $category->name]))

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">{{ __('Events in Category: :category', ['category' => $category->name]) }}</h1>

                <div class="row">
                    @forelse($events as $event)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100">
                                @if($event->image)
                                    <img src="{{ RvMedia::getImageUrl($event->image, 'medium') }}" class="card-img-top"
                                        alt="{{ $event->name }}">
                                @endif

                                <div class="card-body">
                                    <h5 class="card-title">{{ $event->name }}</h5>
                                    <p class="card-text text-muted">{{ Str::limit($event->description, 100) }}</p>
                                    <p class="text-muted"><small>{{ $event->start_date }}</small></p>
                                    <a href="{{ route('public.events.detail', $event->slug) }}" class="btn btn-primary">View
                                        Details</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p>No events found in this category.</p>
                        </div>
                    @endforelse
                </div>

                @if($events->hasPages())
                    {{ $events->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection