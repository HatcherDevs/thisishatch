@extends('theme.sharjah-triennial::layouts.master')

@section('content')
    <div class="container py-5">
        <h1 class="mb-4">{{ __('plugins/sharjah-event-calendar::events.all_events') }}</h1>

        <div class="row">
            @forelse($events as $event)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        @if($event->image)
                            <img src="{{ RvMedia::getImageUrl($event->image, 'medium') }}" class="card-img-top"
                                alt="{{ $event->name }}">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $event->name }}</h5>
                            <p class="card-text">{{ Str::limit($event->description, 100) }}</p>
                            <p class="text-muted"><small>{{ $event->start_date }}</small></p>
                            <a href="{{ route('public.events.detail', $event->slug) }}" class="btn btn-primary">View Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <p>No events found.</p>
                </div>
            @endforelse
        </div>

        @if($events->hasPages())
            {{ $events->links() }}
        @endif
    </div>
@endsection