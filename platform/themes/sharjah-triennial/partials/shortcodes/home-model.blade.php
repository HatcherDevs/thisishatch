@php
    use Botble\Shortcode\Facades\Shortcode;
    use Botble\Media\Facades\RvMedia;

    $items = Shortcode::fields()->getTabsData(
        ['media_image', 'category', 'date', 'time', 'title', 'description', 'button_text', 'button_link'],
        $shortcode,
    );
@endphp

<style>
    .event-section .ck-content hr,.divider {
        border: none !important;
        border-top: var(--main-border) !important;
        margin: 0 !important;
        transition: var(--transition) !important;
        border-width: 3px !important;
        border-color: #000 !important;
    }

    .event-section:not(:first-of-type) {
    margin: 25px auto 0 auto !important;
    padding-top: 5px !important;
}
</style>

@if (!empty($items))
    @php $counter = 0; @endphp
    @foreach ($items as $item)
        <section class="event-section mt-0" id="events">
            <hr class="divider" />
            <div class="event-block row g-0">
                <a href="{{ $item['button_link'] ?? '#' }}" class="event-block-link">Go to event</a>

                @if ($counter % 2 === 0)
                    <!-- Text content (left) -->
                    <div class="col-md-5 order-2 order-md-1">
                        <div class="event-info event-info_p_left event-info_p_right d-flex flex-column h-100">
                            <div class="event-meta-row d-flex justify-content-between align-items-end my-2">
                                <span>{{ $item['category'] ?? 'Event' }}</span>
                                <span>{{ $item['date'] ?? '' }} {{ $item['time'] ?', ' . $item['time'] : '' }}</span>
                            </div>
                            <hr class="divider" />
                            <span class="event-title">{{ $item['title'] ?? '' }}</span>
                            <div class="event-desc">
                                {{ $item['description'] ?? '' }}
                            </div>
                            @if (!empty($item['button_text']) && !empty($item['button_link']))
                                <a href="{{ $item['button_link'] }}" class="event-readmore mt-auto"
                                    aria-label="Read more about {{ $item['title'] ?? 'Event' }}">
                                    <i class="fa fa-arrow-right"></i>
                                    {{ $item['button_text'] }}
                                </a>
                            @endif
                        </div>
                    </div>
                    <!-- Image (right) -->
                    <div class="col-md-7 order-1 order-md-2">
                        <div class="event-image">
                            @if (!empty($item['media_image']))
                                <img src="{{ RvMedia::getImageUrl($item['media_image'], 'medium', false, RvMedia::getDefaultImage()) }}"
                                    alt="Event image for {{ $item['title'] ?? 'Event' }}" loading="lazy" />
                            @endif
                        </div>
                    </div>
                @else
                    <!-- Image (left) -->
                    <div class="col-md-7 order-1 order-md-1">
                        <div class="event-image">
                            @if (!empty($item['media_image']))
                                <img src="{{ RvMedia::getImageUrl($item['media_image'], 'medium', false, RvMedia::getDefaultImage()) }}"
                                    alt="Event image for {{ $item['title'] ?? 'Event' }}" loading="lazy" />
                            @endif
                        </div>
                    </div>
                    <!-- Text content (right) -->
                    <div class="col-md-5 order-2 order-md-2">
                        <div class="event-info event-info_p_left event-info_p_left_10px d-flex flex-column h-100">
                            <div class="event-meta-row d-flex justify-content-between align-items-end my-2">
                                <span>{{ $item['category'] ?? 'Event' }}</span>
                                <span>{{ $item['date'] ?? '' }} {{ $item['time'] ?', ' . $item['time'] : '' }}</span>
                            </div>
                            <hr class="divider" />
                            <span class="event-title">{{ $item['title'] ?? '' }}</span>
                            <div class="event-desc">
                                {{ $item['description'] ?? '' }}
                            </div>
                            @if (!empty($item['button_text']) && !empty($item['button_link']))
                                <a href="{{ $item['button_link'] }}" class="event-readmore mt-auto"
                                    aria-label="Read more about {{ $item['title'] ?? 'Event' }}">
                                    <i class="fa fa-arrow-right"></i>
                                    {{ $item['button_text'] }}
                                </a>
                            @endif
                        </div>
                    </div>
                @endif


            </div>
            <hr class="divider" />
        </section>
        @php $counter++; @endphp
    @endforeach
@endif

@push('footer')
@endpush
