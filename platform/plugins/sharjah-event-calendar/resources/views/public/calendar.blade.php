@extends('plugins.sharjah-event-calendar::layouts.public')

@section('title', __('Calendar'))

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <h1 class="mb-4">{{ __('Calendar View') }}</h1>

                <div class="card">
                    <div class="card-body">
                        <p class="text-muted">{{ __('Calendar view will be implemented here') }}</p>

                        <div class="row">
                            @foreach($events as $event)
                                <div class="col-md-6 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $event->name }}</h6>
                                            <p class="card-text">{{ $event->start_date }}</p>
                                            <a href="{{ route('public.events.detail', $event->slug) }}"
                                                class="btn btn-sm btn-primary">
                                                {{ __('View Details') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection