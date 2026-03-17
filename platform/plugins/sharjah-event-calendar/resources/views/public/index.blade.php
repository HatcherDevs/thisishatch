@extends('theme.sharjah-triennial::layouts.master')



@section('title', __('plugins/sharjah-event-calendar::events.all_events'))

@section('content')
    <main class="event-section whatsOn_page mt-0">


        <section class="row mb-5">
            <div class="col-12">
                <div class="row">
                    <div class="col-md-6">
                        <hr class="divider" />
                        <h2 class="" style="font-size: 26px; margin: 6px 0 ;">Calendar</h2>
                        <hr class="divider" />
                    </div>
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('public.events.index') }}" id="filterForm">
                            <div class="select-date-wrap">
                                <div class="col">
                                    <select class="form-select" aria-label="Venues" name="location"
                                        onchange="document.getElementById('filterForm').submit()">
                                        <option value="">All Venues</option>
                                        @foreach($locations as $location)
                                            <option value="{{ $location->id }}" {{ request('location') == $location->id ? 'selected' : '' }}>
                                                {{ $location->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="form-select" aria-label="Status" name="event_status"
                                        onchange="document.getElementById('filterForm').submit()">
                                        <option value="">All Events</option>
                                        <option value="ongoing" {{ request('event_status') == 'ongoing' ? 'selected' : '' }}>
                                            Ongoing</option>
                                        <option value="upcoming" {{ request('event_status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                        <option value="completed" {{ request('event_status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="form-select" aria-label="Types" name="category"
                                        onchange="document.getElementById('filterForm').submit()">
                                        <option value="">All types</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


        </section>





        <section class="mb-4 mt-5 pt-5">
            <hr class="divider" />
            <h3 class="my-2" style="font-size: 22px">
                @if(request('event_status') == 'ongoing')
                    Ongoing Events
                @elseif(request('event_status') == 'upcoming')
                    Upcoming Events
                @elseif(request('event_status') == 'completed')
                    Completed Events
                @else
                    All Events
                @endif
            </h3>
            <hr class="divider" />
            <div class="row g-3 mt-1">

                @forelse($events as $event)
                    <!-- Event Card -->
                    <div class="col-6 col-xl-3 latest-card-wrap">
                        <div class="latest-card h-100 d-flex flex-column border-bottom border-black border-3">
                            <a href="{{ route('public.events.detail', $event->slug) }}" class="latest-card-link">Go to event</a>

                            @if($event->image)
                                <div class="latest-img-wrap">
                                    <img src="{{ RvMedia::getImageUrl($event->image, 'medium') }}" alt="{{ $event->name }}" />
                                </div>
                            @endif

                            <hr class="latest-hr border-0 border-top border-black border-3 m-0" />

                            <div
                                class="d-flex justify-content-between latest-title-wrap p-2 fw-bold custom-font-size custom-margin-bottom ps-0">
                                <div>
                                    <span>{{ $event->start_date ? $event->start_date->format('M d') : 'TBA' }}</span>
                                </div>
                                <div>
                                    <span>{{ $event->location ? $event->location->name : 'TBA' }}</span>
                                </div>
                            </div>

                            <hr class="latest-hr border-0 border-top border-black border-3 m-0" />

                            <div
                                class="latest-title-wrap p-2 fw-bold custom-font-size border-bottom border-black border-3 custom-margin-bottom ps-0">
                                {{ $event->name }}
                            </div>

                            <div class="latest-desc pt-0 custom-padding-bottom custom-font-size pt-2">
                                {{ Str::limit($event->description, 150) }}
                            </div>
                        </div>

                        <div>
                            @if($event->category)
                                <a href="{{ route('public.events.category', $event->category->slug) }}" class="btn tag my-2">
                                    {{ $event->category->name }}
                                </a>
                            @endif
                            <hr class="latest-hr" style="border: none; border-top: 3px solid #000; margin: 0 0 0 0;" />
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info">
                            No events found matching your filters.
                        </div>
                    </div>
                @endforelse

            </div>

            @if($events->hasPages())
                <div class="mt-4">
                    {{ $events->appends(request()->query())->links() }}
                </div>
            @endif
        </section>



    </main>
@endsection