@extends('theme.sharjah-triennial::layouts.master')
@section('title', $event->name)

@section('content')







    @php
        // dd($event);
    @endphp






    <main class="event-section about_page">
        <!-- Event Detail Section -->
        <section class="row mb-5">
            <div class="col-12 header_img">
                @if($event->image)
                    <img class="border-top border-3 border-black" src="{{ RvMedia::getImageUrl($event->image) }}"
                        alt="{{ $event->name }}" style="width: 100%; height: 100%; object-fit: cover; display: block" />
                @endif
            </div>
            <div class="col-12">
                <hr class="divider" />
                <h2 class="my-1" style="font-size: 26px">{{ $event->name }}</h2>
                <hr class="divider" />
                <div class="row">
                    <div class="col-lg-5 mb-4 mb-lg-0">
                        <ul class="list-group about-menu">
                            @if($event->start_date)
                                @php
                                    $hasTwoDates = $event->end_date && $event->start_date->format('Y-m-d') != $event->end_date->format('Y-m-d');
                                    $hasTwoTimes = $event->start_time && $event->end_time;
                                    $hasOneTime = ($event->start_time && !$event->end_time) || (!$event->start_time && $event->end_time);
                                    $separateTimes = $hasTwoDates && $hasTwoTimes;
                                @endphp

                                <li class="list-group-item ps-0">
                                    <a class="text-decoration-none text-dark" href="">
                                        <i class="fa-solid fa-arrow-right"></i>
                                        @if($hasTwoDates)
                                            {{-- تاريخ بداية ونهاية مختلفين --}}
                                            {{ $event->start_date->format('F j') }} - {{ $event->end_date->format('F j') }}
                                            @if(!$separateTimes && ($event->start_time || $event->end_time))
                                                {{-- وقت واحد فقط بجانب التاريخين --}}
                                                -
                                                @if($event->start_time)
                                                    {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}
                                                @endif
                                                @if($event->end_time && !$event->start_time)
                                                    {{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}
                                                @endif
                                            @endif
                                        @else
                                            {{-- تاريخ واحد فقط --}}
                                            {{ $event->start_date->format('F j') }}
                                            @if($event->start_time || $event->end_time)
                                                -
                                                @if($event->start_time)
                                                    {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}
                                                @endif
                                                @if($event->end_time)
                                                    - {{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}
                                                @endif
                                            @endif
                                        @endif
                                    </a>
                                </li>
                            @endif

                            @if($event->end_date && $event->start_date->format('Y-m-d') != $event->end_date->format('Y-m-d') && $event->start_time && $event->end_time)
                                {{-- تاريخين + وقتين -> li منفصلة للأوقات --}}
                                <li class="list-group-item ps-0">
                                    <a class="text-decoration-none text-dark" href="">
                                        <i class="fa-solid fa-arrow-right"></i>
                                        {{ \Carbon\Carbon::parse($event->start_time)->format('g:i A') }}
                                        - {{ \Carbon\Carbon::parse($event->end_time)->format('g:i A') }}
                                    </a>
                                </li>
                            @endif

                            @if($event->location)
                                <li class="list-group-item ps-0">
                                    <a class="text-decoration-none text-dark" href="">
                                        <i class="fa-solid fa-arrow-right"></i>
                                        {{ $event->location->name }}
                                    </a>
                                </li>
                            @endif


                            @if($event->has_registration && $event->canRegister())
                                <li class="list-group-item ps-0">
                                    <a class="text-decoration-none text-dark" href="#" data-bs-toggle="modal"
                                        data-bs-target="#registrationModal">
                                        <i class="fa-solid fa-arrow-right"></i>
                                        RSVP
                                    </a>
                                </li>
                            @endif

                            @if($event->category)
                                <li class="list-group-item ps-0">
                                    <a class="tag" href="{{ route('public.events.category', $event->category->slug) }}">
                                        {{ $event->category->name }}
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-lg-7">
                        <div class="desc pb-md-4 fs-5 mb-5">
                            @if($event->description)
                                <p style="line-height: normal">
                                    {{ $event->description }}
                                </p>
                            @endif

                            @if($event->content)
                                <div style="line-height: normal">
                                    {!! BaseHelper::clean($event->content) !!}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Registration Modal -->
        @if($event->has_registration)
            <div class="modal fade" id="registrationModal" tabindex="-1" aria-labelledby="registrationModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="registrationModalLabel">Register for {{ $event->name }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @if($event->canRegister())
                                <div class="alert alert-info mb-3">
                                    @if($event->max_attendees)
                                        <p class="mb-2">
                                            <strong>Available Spots:</strong>
                                            {{ $event->max_attendees - $event->registrations()->where('status', 'approved')->count() }}
                                            / {{ $event->max_attendees }}
                                        </p>
                                    @endif
                                    @if($event->registration_deadline)
                                        <p class="mb-0">
                                            <strong>Registration Deadline:</strong>
                                            {{ $event->registration_deadline->format('F d, Y H:i') }}
                                        </p>
                                    @endif
                                </div>

                                <form method="POST" action="{{ route('public.events.register', $event->slug) }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Name <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Phone</label>
                                        <input type="text" name="phone" class="form-control">
                                    </div>

                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary flex-fill">
                                            Register Now
                                        </button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            @elseif($event->isFull())
                                <div class="alert alert-danger">
                                    <i class="fas fa-exclamation-circle"></i>
                                    This event is fully booked.
                                </div>
                            @else
                                <div class="alert alert-warning">
                                    <i class="fas fa-info-circle"></i>
                                    Registration for this event is closed.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </main>
@endsection