@extends('theme.sharjah-triennial::layouts.master')


@push('css')
    <style>
        /* Map page specific styles */
        .map-wrapper {
            width: 100%;
            height: 640px;
            position: relative;
        }

        #map {
            width: 100%;
            height: 100%;
        }

        /* Marker Container */
        .marker-container {
            position: relative;
            width: 0;
            height: 0;
            z-index: 2000;
        }

        /* Marker Hover Box Styles */
        .marker-hover-box {
            position: absolute;
            background: #fff;
            border: 3px solid #000;
            padding: 12px;
            border-radius: 4px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
            z-index: 10000 !important;
            display: none;
            min-width: 200px;
            max-width: 220px;
            bottom: 25px;
            left: 50%;
            transform: translateX(-50%);
            pointer-events: none;
            white-space: normal;
        }

        /* Timeline Overlay Styles */
        .timeline-overlay {
            position: absolute;
            top: 40px;
            left: 20px;
            bottom: 40px;
            z-index: 1000;
            pointer-events: auto;
            width: 220px;
        }

        .timeline-section {
            /* background: #fff;
                                border: 3px solid #000;
                                border-radius: 8px;
                                padding: 20px;
                                box-shadow: 0 4px 12px rgba(0,0,0,0.3); */
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .timeline-title {
            flex-shrink: 0;
            margin-bottom: 20px;
        }

        .timeline-title h3 {
            font-size: 16px;
            font-weight: 600;
            color: #000;
            margin-bottom: 0;
            text-align: center;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .timeline-container {
            position: relative;
            padding-left: 30px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .timeline-line {
            position: absolute;
            left: 15px;
            top: 0;
            bottom: 0;
            width: 3px;
            background: #000;
            border-radius: 2px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 0;
            cursor: pointer;
            transition: all 0.3s ease;
            flex: 1;
            display: flex;
            align-items: center;
        }

        .timeline-dot {
            position: absolute;
            left: -22px;
            top: 50%;
            transform: translateY(-50%);
            width: 17px;
            height: 17px;
            background: #fff;
            border: 3px solid #000;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .timeline-item.active .timeline-dot {
            background: #000;
            transform: translateY(-50%) scale(1.2);
        }

        .timeline-content h4 {
            font-size: 14px;
            font-weight: 600;
            color: #000;
            margin: 0 0 4px 0;
            line-height: 1.3;
        }

        .timeline-content p {
            font-size: 11px;
            color: #666;
            margin: 0;
            line-height: 1.3;
        }

        /* .timeline-item:hover {
                                transform: translateX(3px);
                              } */

        .timeline-item:hover .timeline-dot {
            background: #000;
            /* transform: translateY(-50%) scale(1.1); */
        }

        .timeline-item.active .timeline-content h4 {
            color: #000;
            font-weight: 700;
        }

        .marker-hover-box img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            border: 2px solid #ddd;
            margin-bottom: 6px;
        }

        /* Add arrow to hover box */
        .marker-hover-box::after {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border: 10px solid transparent;
            border-top-color: #000;
        }

        .marker-hover-box::before {
            content: '';
            position: absolute;
            top: 100%;
            left: 50%;
            transform: translateX(-50%);
            border: 8px solid transparent;
            border-top-color: #fff;
            margin-top: -3px;
        }

        .marker-hover-box h4 {
            margin: 0 0 4px 0;
            font-size: 14px;
            font-weight: 600;
            color: #000;
            line-height: 1.3;
        }

        .marker-hover-box p {
            margin: 0;
            font-size: 12px;
            color: #666;
            line-height: 1.3;
        }

        /* Offcanvas Styles */
        .offcanvas {
            z-index: 333322000;
        }

        .offcanvas-bottom {
            height: calc(100vh - 70px) !important;
            /* Full height minus navbar + spacing */
            border-top: 3px solid #000;
            top: auto !important;
            bottom: 0 !important;
            max-height: calc(100vh - 70px) !important;
        }

        .offcanvas-body {
            padding: 0;
            display: flex;
            height: 100%;
        }

        .offcanvas-content {
            display: flex;
            width: 100%;
            height: 100%;
        }

        .offcanvas-text {
            flex: 1;
            padding: 30px;
            /* overflow-y: auto; */
            background: #fff;
        }

        .offcanvas-image {
            width: 50%;
            position: sticky;
            top: 0;
            /* height: 100%; */
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            /* border-left: 3px solid #000; */
        }

        .offcanvas-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .offcanvas-header {
            border-bottom: 3px solid #000;
            border-top: 3px solid #000;
            padding: 15px 30px;
            background: #fff;
        }

        .offcanvas-title {
            font-size: 20px;
            font-weight: 600;
            margin: 0;
        }

        .btn-close {
            font-size: 24px;
            border: 3px solid #000;
            border-radius: 0;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            color: #000;
        }

        .btn-close:hover {
            background: #000;
            color: #fff;
        }

        .offcanvas-text h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #000;
        }

        .offcanvas-text p {
            font-size: 14px;
            line-height: 1.6;
            margin-bottom: 15px;
            color: #333;
        }

        .offcanvas-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .detail-item {
            font-size: 14px;
        }

        .detail-label {
            font-weight: 600;
            margin-bottom: 5px;
            color: #000;
        }

        .detail-value {
            color: #666;
        }
    </style>
@endpush


@section('content')

    @php
        $pageData = Theme::page();

        // Get Research Timeline Categories
        $timelines = \Botble\Research\Models\Timeline::query()
            ->where('status', 'published')
            ->orderBy('order', 'asc')
            ->get();

        // Get Research Locations with Timeline relationship
        $locations = \Botble\Research\Models\Location::query()
            ->with('timeline')
            ->where('status', 'published')
            ->orderBy('order', 'asc')
            ->get();

        // Group locations by timeline
        $locationsByTimeline = $locations->groupBy('timeline_id');

        // Get page-specific map settings first
        $pageMapPoints = get_field('map_points', $pageData->id ?? 0) ?: [];
        $pageMapCenter = get_field('map_center', $pageData->id ?? 0) ?: '';
        $pageMapZoom = get_field('map_zoom', $pageData->id ?? 0) ?: '';

        // Parse map center coordinates
        $centerCoords = [];
        if (!empty($pageMapCenter)) {
            $coords = explode(',', $pageMapCenter);
            if (count($coords) >= 2) {
                $centerCoords = [
                    'lat' => trim($coords[0]),
                    'lng' => trim($coords[1]),
                ];
            }
        }

        // Get theme default settings as fallback
        $themeMapPoints = theme_option('map_points', []);
        $defaultLat = $centerCoords['lat'] ?? theme_option('default_map_center_lat', '25.3463');
        $defaultLng = $centerCoords['lng'] ?? theme_option('default_map_center_lng', '55.4209');
        $defaultZoom = $pageMapZoom ?: theme_option('default_map_zoom', '12');

        // Use page-specific points if available, otherwise theme points, otherwise child pages
        $mapPoints = [];
        if (!empty($pageMapPoints) && is_array($pageMapPoints)) {
            $mapPoints = $pageMapPoints;
        } elseif (!empty($themeMapPoints)) {
            $mapPoints = $themeMapPoints;
        } else {
            // Get child pages as fallback
            $childPages = collect();
            if ($pageData) {
                $childPages = \Botble\Page\Models\Page::query()
                    ->where('parent_id', $pageData->id)
                    ->where('status', 'published')
                    ->orderBy('created_at', 'asc')
                    ->orderBy('order', 'asc')
                    ->orderBy('name', 'asc')
                    ->get();
            }

            // Convert child pages to map points
            if ($childPages->isNotEmpty()) {
                $mapPoints = $childPages
                    ->map(function ($child, $index) use ($defaultLat, $defaultLng) {
                        return [
                            'title' => $child->name,
                            'description' => $child->description ?: strip_tags(Str::limit($child->content, 100)),
                            'latitude' => (float) $defaultLat + $index * 0.01,
                            'longitude' => (float) $defaultLng + $index * 0.01,
                            'link_url' => $child->url,
                            'is_visible' => true,
                        ];
                    })
                    ->toArray();
            }
        }

        // Filter only visible points
        $visibleMapPoints = collect($mapPoints)->filter(function ($point) {
            return !empty($point['is_visible']) && $point['is_visible'] !== '0';
        });

        // Get child pages for the locations list (separate from map points)
        $childPagesForList = collect();
        if ($pageData) {
            $childPagesForList = \Botble\Page\Models\Page::query()
                ->where('parent_id', $pageData->id)
                ->where('status', 'published')
                ->orderBy('order', 'asc')
                ->orderBy('created_at', 'asc')
                ->orderBy('name', 'asc')
                ->get();
        }

        // Get menu items field
        $menuItems = get_field('menu_items', $pageData->id ?? 0);
        $menuShowState = get_field('show_menu', $pageData->id ?? 0);

    @endphp

    <main id="main-content" class="main-content event-section about_page">

        {{-- Header Map Section --}}
        <section class="row">
            <div class="col-12">
                <hr class="divider" />
                <div class="map-wrapper position-relative" dir="ltr">
                    <div id="map"></div>

                    <!-- Timeline Overlay on Map -->
                    <div class="timeline-overlay">
                        <div class="timeline-section">
                            <div class="timeline-container">
                                <div class="timeline-line"></div>
                                @foreach ($timelines as $timeline)
                                    <div class="timeline-item" data-period="timeline-{{ $timeline->id }}"
                                        data-color="{{ $timeline->color ?? '#000000' }}">
                                        <div class="timeline-dot" style="border-color: #000000"></div>
                                        <div class="timeline-content">
                                            <h4>{{ $timeline->name }}</h4>
                                            @if ($timeline->subtitle)
                                                <p>{{ $timeline->subtitle }}</p>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- Page Content Section --}}
        <section class="row mb-5">
            <div class="col-12">
                <hr class="divider" />
                <h2 class="my-1" style="font-size: 26px">{{ $pageData->name }}</h2>
                <hr class="divider" />
                <div class="row">
                    <div class="col-lg-5 mb-4 mb-lg-0">
                        @if ($childPagesForList->isNotEmpty())
                            <ul class="list-group about-menu">
                                @foreach ($childPagesForList as $child)
                                    <li class="list-group-item ps-0">
                                        <a class="text-decoration-none text-dark" href="{{ $child->url }}"
                                            title="{{ $child->description ?? $child->name }}">
                                            <i class="fa-solid fa-arrow-right"></i>

                                            {{ $child->name }}


                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @endif



                        @if (!empty($menuItems) && is_array($menuItems) && $menuShowState == 'on')
                            <ul class="list-group about-menu">
                                @foreach ($menuItems as $menuItem)
                                    @if (!empty($menuItem['is_visible']) && $menuItem['is_visible'] == '1')
                                        <li class="list-group-item ps-0">
                                            <a class="text-decoration-none text-dark" href="{{ $menuItem['link'] ?? '#' }}"
                                                data-period="{{ $menuItem['timeline_id'] ?? 'null' }}">
                                                <i class="fa-solid fa-arrow-right"></i>
                                                {{ $menuItem['name'] ?? '' }}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        @endif


                    </div>

                    <div class="col-lg-7">
                        <div class="desc pt-md-4 mt-3 fs-5">
                            {!! Theme::content() !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @if ($childPagesForList->isNotEmpty())
            <section class="mb-5 mt-5">
                <hr class="divider" />
                <h3 class="my-2" style="font-size: 22px">{{ $pageData->name }} Sections</h3>
                <hr class="divider" />
                <div class="row g-3 mt-1">
                    @foreach ($childPagesForList as $child)
                        <div class="col-6 col-xl-3 latest-card-wrap">
                            <div class="latest-card h-100 d-flex flex-column border-bottom border-black border-3">
                                <a href="{{ $child->url }}" class="latest-card-link">Go to {{ $child->name }}</a>
                                <div class="latest-img-wrap">
                                    @if ($child->image)
                                        <img src="{{ RvMedia::getImageUrl($child->image) }}" alt="{{ $child->name }}" />
                                    @else
                                        <img src="https://cdn.sanity.io/images/kh6stm8m/production/6e1abcd77b2b920247a7f09da85c33e6299c0bb7-3000x2003.jpg"
                                            alt="{{ $child->name }}" />
                                    @endif
                                </div>
                                <hr class="latest-hr border-0 border-top border-black border-3 m-0" />
                                <div
                                    class="latest-title-wrap p-2 fw-bold custom-font-size border-bottom border-black border-3 custom-margin-bottom ps-0">
                                    {{ $child->name }}
                                </div>
                                <div class="latest-desc pt-0 custom-padding-bottom custom-font-size pt-2">
                                    {{ !empty($child->description) ? $child->description : Str::limit(strip_tags($child->content), 250) }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif


    </main>

    <!-- Offcanvas Modal -->
    <div class="offcanvas offcanvas-bottom" tabindex="-1" id="markerOffcanvas" aria-labelledby="markerOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="markerOffcanvasLabel">Location Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close">×</button>
        </div>
        <div class="offcanvas-body">
            <div class="offcanvas-content">
                <div class="offcanvas-text">
                    <h3 id="offcanvasLocationName">Location Name</h3>

                    <div class="offcanvas-details" id="offcanvasDetailsContainer">
                        <div class="detail-item" id="offcanvasTypologyItem" style="display: none;">
                            <div class="detail-label">{{ isArabic() ? 'النوع:' : 'Typology:' }}</div>
                            <div class="detail-value" id="offcanvasTypology">-</div>
                        </div>
                        <div class="detail-item" id="offcanvasZoneItem" style="display: none;">
                            <div class="detail-label">{{ isArabic() ? 'المنطقة:' : 'Zone:' }}</div>
                            <div class="detail-value" id="offcanvasZone">-</div>
                        </div>
                        <div class="detail-item" id="offcanvasPlotAreaItem" style="display: none;">
                            <div class="detail-label">{{ isArabic() ? 'مساحة الأرض:' : 'Plot Area:' }}</div>
                            <div class="detail-value" id="offcanvasPlotArea">-</div>
                        </div>
                        <div class="detail-item" id="offcanvasBuiltAreaItem" style="display: none;">
                            <div class="detail-label">{{ isArabic() ? 'المساحة المبنية:' : 'Built-up Area:' }}</div>
                            <div class="detail-value" id="offcanvasBuiltArea">-</div>
                        </div>
                    </div>

                    <div id="offcanvasDescription"></div>
                </div>
                <div class="offcanvas-image">
                    <img id="offcanvasImage"
                        src="https://cdn.sanity.io/images/kh6stm8m/production/e9bb70de952d27c060823b3d2e0aad268a4fc412-1650x870.jpg"
                        alt="Location Image">
                </div>
            </div>
        </div>
    </div>

@endsection

@push('footer')
    <script>
        // Initialize Mapbox map with colored markers
        mapboxgl.accessToken =
            'pk.eyJ1IjoiYWJkZWxyaG1hbmF0d2EzOSIsImEiOiJjbWQyZTZoZGMxN280Mmxxd3d3NWw1aHMyIn0.YcekKacapqijA-aHi_hkgg';

        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/light-v11',
            center: [55.4023, 25.34648],
            zoom: 12.7,
            interactive: true
        });

        // Marker data from database - organized by timeline
        const timelineData = {
            @foreach ($timelines as $timeline)
                'timeline-{{ $timeline->id }}': [
                    @if (isset($locationsByTimeline[$timeline->id]))
                        @foreach ($locationsByTimeline[$timeline->id] as $location)
                            {
                                coords: [55.4023 + {{ $loop->index * 0.01 }}, 25.34648 +
                                    {{ $loop->index * 0.01 }}
                                ],
                                color: '{{ $timeline->color ?? '#000000' }}',
                                name: {!! json_encode($location->title) !!},
                                typology: {!! json_encode($location->typology ?? '') !!},
                                zone: {!! json_encode($location->zone ?? '') !!},
                                plotArea: {!! json_encode($location->plot_area ?? '') !!},
                                builtArea: {!! json_encode($location->built_up_area ?? '') !!},
                                image: {!! json_encode(
                                    $location->image
                                        ? RvMedia::getImageUrl($location->image)
                                        : 'https://cdn.sanity.io/images/kh6stm8m/production/6e1abcd77b2b920247a7f09da85c33e6299c0bb7-3000x2003.jpg',
                                ) !!},
                                description: {!! json_encode($location->description ?? ($location->subtitle ?? '')) !!}
                            }
                            {{ !$loop->last ? ',' : '' }}
                        @endforeach
                    @endif
                ] {{ !$loop->last ? ',' : '' }}
            @endforeach
        };

        // Current active markers
        let currentMarkers = [];
        let currentPeriod = null;

        // Create markers with hover and click functionality
        const bounds = new mapboxgl.LngLatBounds();

        // Function to create markers for a specific period
        function createMarkersForPeriod(period) {
            // Clear existing markers
            currentMarkers.forEach(marker => marker.remove());
            currentMarkers = [];

            const markersData = timelineData[period] || [];
            const bounds = new mapboxgl.LngLatBounds();

            markersData.forEach((markerData, index) => {
                // Add coordinates to bounds
                bounds.extend(markerData.coords);

                // Create marker container
                const markerContainer = document.createElement('div');
                markerContainer.className = 'marker-container';

                // Create marker element (the circle)
                const markerElement = document.createElement('div');
                markerElement.style.width = '16px';
                markerElement.style.height = '16px';
                markerElement.style.borderRadius = '50%';
                markerElement.style.background = markerData.color;
                markerElement.style.border = '2px solid #fff';
                markerElement.style.boxShadow = '0 2px 4px rgba(0,0,0,0.3)';
                markerElement.style.cursor = 'pointer';
                markerElement.style.transition = 'all 0.2s ease';
                markerElement.style.position = 'relative';
                markerElement.style.zIndex = '1';

                // Create hover box
                const hoverBox = document.createElement('div');
                hoverBox.className = 'marker-hover-box';
                hoverBox.innerHTML = `
            <img src="${markerData.image}" alt="${markerData.name}">
            <h4>${markerData.name}</h4>
            <p>${markerData.typology}</p>
          `;

                markerContainer.appendChild(markerElement);
                markerContainer.appendChild(hoverBox);

                // Hover events
                markerContainer.addEventListener('mouseenter', function() {
                    // Raise z-index of this marker container above all others
                    markerContainer.style.zIndex = '99999';

                    hoverBox.style.display = 'block';
                    markerElement.style.width = '20px';
                    markerElement.style.height = '20px';
                    markerElement.style.boxShadow = '0 3px 6px rgba(0,0,0,0.5)';

                    // Smart sensor to check if hover box is outside map bounds
                    setTimeout(function() {
                        const markerPoint = map.project(markerData.coords);
                        const mapContainer = map.getContainer();
                        const mapHeight = mapContainer.offsetHeight;
                        const mapWidth = mapContainer.offsetWidth;

                        // Hover box dimensions (approximate)
                        const hoverBoxHeight = 220; // Height of hover box + margin
                        const hoverBoxWidth = 220; // Width of hover box

                        // Calculate if hover box would be outside bounds
                        let offsetX = 0;
                        let offsetY = 0;

                        // Check top boundary
                        if (markerPoint.y < hoverBoxHeight) {
                            // Box would be cut off at top - move map down
                            offsetY = -(hoverBoxHeight - markerPoint.y + 30);
                        }

                        // Check bottom boundary
                        else if (markerPoint.y > (mapHeight - 50)) {
                            // Marker near bottom - move map up slightly
                            offsetY = 50;
                        }

                        // Check left boundary
                        if (markerPoint.x < (hoverBoxWidth / 2 + 20)) {
                            // Box would be cut off at left - move map right
                            offsetX = (hoverBoxWidth / 2 + 20 - markerPoint.x);
                        }

                        // Check right boundary
                        else if (markerPoint.x > (mapWidth - hoverBoxWidth / 2 - 20)) {
                            // Box would be cut off at right - move map left
                            offsetX = -(markerPoint.x - (mapWidth - hoverBoxWidth / 2 - 20));
                        }

                        // Apply offset if needed
                        if (offsetX !== 0 || offsetY !== 0) {
                            map.easeTo({
                                center: markerData.coords,
                                duration: 400,
                                offset: [offsetX, offsetY]
                            });
                        }
                    }, 50); // Small delay to ensure hover box is rendered
                });

                markerContainer.addEventListener('mouseleave', function() {
                    // Reset z-index when leaving
                    markerContainer.style.zIndex = '1';

                    hoverBox.style.display = 'none';
                    markerElement.style.width = '16px';
                    markerElement.style.height = '16px';
                    markerElement.style.boxShadow = '0 2px 4px rgba(0,0,0,0.3)';
                });

                // Click event to open offcanvas
                markerContainer.addEventListener('click', function() {
                    // Update offcanvas content
                    document.getElementById('markerOffcanvasLabel').textContent = markerData.name;
                    document.getElementById('offcanvasLocationName').textContent = markerData.name;

                    // Show/hide and update Typology
                    const typologyItem = document.getElementById('offcanvasTypologyItem');
                    if (markerData.typology && markerData.typology.trim() !== '') {
                        document.getElementById('offcanvasTypology').textContent = markerData.typology;
                        typologyItem.style.display = 'block';
                    } else {
                        typologyItem.style.display = 'none';
                    }

                    // Show/hide and update Zone
                    const zoneItem = document.getElementById('offcanvasZoneItem');
                    if (markerData.zone && markerData.zone.trim() !== '') {
                        document.getElementById('offcanvasZone').textContent = markerData.zone;
                        zoneItem.style.display = 'block';
                    } else {
                        zoneItem.style.display = 'none';
                    }

                    // Show/hide and update Plot Area
                    const plotAreaItem = document.getElementById('offcanvasPlotAreaItem');
                    if (markerData.plotArea && markerData.plotArea.trim() !== '') {
                        document.getElementById('offcanvasPlotArea').textContent = markerData.plotArea;
                        plotAreaItem.style.display = 'block';
                    } else {
                        plotAreaItem.style.display = 'none';
                    }

                    // Show/hide and update Built-up Area
                    const builtAreaItem = document.getElementById('offcanvasBuiltAreaItem');
                    if (markerData.builtArea && markerData.builtArea.trim() !== '') {
                        document.getElementById('offcanvasBuiltArea').textContent = markerData.builtArea;
                        builtAreaItem.style.display = 'block';
                    } else {
                        builtAreaItem.style.display = 'none';
                    }

                    // Hide details container if all items are hidden
                    const detailsContainer = document.getElementById('offcanvasDetailsContainer');
                    const hasVisibleItems = typologyItem.style.display !== 'none' ||
                        zoneItem.style.display !== 'none' ||
                        plotAreaItem.style.display !== 'none' ||
                        builtAreaItem.style.display !== 'none';
                    detailsContainer.style.display = hasVisibleItems ? 'grid' : 'none';

                    document.getElementById('offcanvasDescription').innerHTML = markerData.description ||
                        '';
                    document.getElementById('offcanvasImage').src = markerData.image;

                    // Show offcanvas
                    const offcanvas = new bootstrap.Offcanvas(document.getElementById('markerOffcanvas'));
                    offcanvas.show();
                });

                // Create and add marker to map with proper anchor
                const marker = new mapboxgl.Marker({
                        element: markerContainer,
                        anchor: 'center'
                    })
                    .setLngLat(markerData.coords)
                    .addTo(map);

                // Store marker reference
                currentMarkers.push(marker);
            });

            // Fit map to show all markers with padding
            if (markersData.length > 0) {
                map.fitBounds(bounds, {
                    padding: {
                        top: 100,
                        bottom: 100,
                        left: 100,
                        right: 100
                    },
                    maxZoom: 14,
                    duration: 1000
                });
            }
        }

        // Function to show all markers from all periods
        function showAllMarkers() {
            // Clear existing markers
            currentMarkers.forEach(marker => marker.remove());
            currentMarkers = [];

            const bounds = new mapboxgl.LngLatBounds();

            // Collect all markers from all periods
            Object.values(timelineData).forEach(periodMarkers => {
                periodMarkers.forEach(markerData => {
                    bounds.extend(markerData.coords);

                    // Create marker container
                    const markerContainer = document.createElement('div');
                    markerContainer.className = 'marker-container';

                    // Create marker element (the circle)
                    const markerElement = document.createElement('div');
                    markerElement.style.width = '16px';
                    markerElement.style.height = '16px';
                    markerElement.style.borderRadius = '50%';
                    markerElement.style.background = markerData.color;
                    markerElement.style.border = '2px solid #fff';
                    markerElement.style.boxShadow = '0 2px 4px rgba(0,0,0,0.3)';
                    markerElement.style.cursor = 'pointer';
                    markerElement.style.transition = 'all 0.2s ease';
                    markerElement.style.position = 'relative';
                    markerElement.style.zIndex = '1';

                    // Create hover box
                    const hoverBox = document.createElement('div');
                    hoverBox.className = 'marker-hover-box';
                    hoverBox.innerHTML = `
              <img src="${markerData.image}" alt="${markerData.name}">
              <h4>${markerData.name}</h4>
              <p>${markerData.typology}</p>
            `;

                    markerContainer.appendChild(markerElement);
                    markerContainer.appendChild(hoverBox);

                    // Hover events
                    markerContainer.addEventListener('mouseenter', function() {
                        // Raise z-index of this marker container above all others
                        markerContainer.style.zIndex = '99999';

                        hoverBox.style.display = 'block';
                        markerElement.style.width = '20px';
                        markerElement.style.height = '20px';
                        markerElement.style.boxShadow = '0 3px 6px rgba(0,0,0,0.5)';

                        // Smart sensor to check if hover box is outside map bounds
                        setTimeout(function() {
                            const markerPoint = map.project(markerData.coords);
                            const mapContainer = map.getContainer();
                            const mapHeight = mapContainer.offsetHeight;
                            const mapWidth = mapContainer.offsetWidth;

                            // Hover box dimensions (approximate)
                            const hoverBoxHeight = 220; // Height of hover box + margin
                            const hoverBoxWidth = 220; // Width of hover box

                            // Calculate if hover box would be outside bounds
                            let offsetX = 0;
                            let offsetY = 0;

                            // Check top boundary
                            if (markerPoint.y < hoverBoxHeight) {
                                // Box would be cut off at top - move map down
                                offsetY = -(hoverBoxHeight - markerPoint.y + 30);
                            }

                            // Check bottom boundary
                            else if (markerPoint.y > (mapHeight - 50)) {
                                // Marker near bottom - move map up slightly
                                offsetY = 50;
                            }

                            // Check left boundary
                            if (markerPoint.x < (hoverBoxWidth / 2 + 20)) {
                                // Box would be cut off at left - move map right
                                offsetX = (hoverBoxWidth / 2 + 20 - markerPoint.x);
                            }

                            // Check right boundary
                            else if (markerPoint.x > (mapWidth - hoverBoxWidth / 2 - 20)) {
                                // Box would be cut off at right - move map left
                                offsetX = -(markerPoint.x - (mapWidth - hoverBoxWidth / 2 -
                                    20));
                            }

                            // Apply offset if needed
                            if (offsetX !== 0 || offsetY !== 0) {
                                map.easeTo({
                                    center: markerData.coords,
                                    duration: 400,
                                    offset: [offsetX, offsetY]
                                });
                            }
                        }, 50); // Small delay to ensure hover box is rendered
                    });

                    markerContainer.addEventListener('mouseleave', function() {
                        // Reset z-index when leaving
                        markerContainer.style.zIndex = '1';

                        hoverBox.style.display = 'none';
                        markerElement.style.width = '16px';
                        markerElement.style.height = '16px';
                        markerElement.style.boxShadow = '0 2px 4px rgba(0,0,0,0.3)';
                    });

                    // Click event to open offcanvas
                    markerContainer.addEventListener('click', function() {
                        // Update offcanvas content
                        document.getElementById('markerOffcanvasLabel').textContent = markerData
                            .name;
                        document.getElementById('offcanvasLocationName').textContent = markerData
                            .name;

                        // Show/hide and update Typology
                        const typologyItem = document.getElementById('offcanvasTypologyItem');
                        if (markerData.typology && markerData.typology.trim() !== '') {
                            document.getElementById('offcanvasTypology').textContent = markerData
                                .typology;
                            typologyItem.style.display = 'block';
                        } else {
                            typologyItem.style.display = 'none';
                        }

                        // Show/hide and update Zone
                        const zoneItem = document.getElementById('offcanvasZoneItem');
                        if (markerData.zone && markerData.zone.trim() !== '') {
                            document.getElementById('offcanvasZone').textContent = markerData.zone;
                            zoneItem.style.display = 'block';
                        } else {
                            zoneItem.style.display = 'none';
                        }

                        // Show/hide and update Plot Area
                        const plotAreaItem = document.getElementById('offcanvasPlotAreaItem');
                        if (markerData.plotArea && markerData.plotArea.trim() !== '') {
                            document.getElementById('offcanvasPlotArea').textContent = markerData
                                .plotArea;
                            plotAreaItem.style.display = 'block';
                        } else {
                            plotAreaItem.style.display = 'none';
                        }

                        // Show/hide and update Built-up Area
                        const builtAreaItem = document.getElementById('offcanvasBuiltAreaItem');
                        if (markerData.builtArea && markerData.builtArea.trim() !== '') {
                            document.getElementById('offcanvasBuiltArea').textContent = markerData
                                .builtArea;
                            builtAreaItem.style.display = 'block';
                        } else {
                            builtAreaItem.style.display = 'none';
                        }

                        // Hide details container if all items are hidden
                        const detailsContainer = document.getElementById(
                            'offcanvasDetailsContainer');
                        const hasVisibleItems = typologyItem.style.display !== 'none' ||
                            zoneItem.style.display !== 'none' ||
                            plotAreaItem.style.display !== 'none' ||
                            builtAreaItem.style.display !== 'none';
                        detailsContainer.style.display = hasVisibleItems ? 'grid' : 'none';

                        document.getElementById('offcanvasDescription').innerHTML = markerData
                            .description || '';
                        document.getElementById('offcanvasImage').src = markerData.image;

                        // Show offcanvas
                        const offcanvas = new bootstrap.Offcanvas(document.getElementById(
                            'markerOffcanvas'));
                        offcanvas.show();
                    });

                    // Create and add marker to map with proper anchor
                    const marker = new mapboxgl.Marker({
                            element: markerContainer,
                            anchor: 'center'
                        })
                        .setLngLat(markerData.coords)
                        .addTo(map);

                    // Store marker reference
                    currentMarkers.push(marker);
                });
            });

            // Fit map to show all markers with padding
            map.fitBounds(bounds, {
                padding: {
                    top: 100,
                    bottom: 100,
                    left: 100,
                    right: 100
                },
                maxZoom: 14,
                duration: 1000
            });
        }

        // Initialize with all markers showing
        showAllMarkers();

        // Timeline functionality
        const timelineItems = document.querySelectorAll('.timeline-item');
        const menuItems = document.querySelectorAll('.about-menu a[data-period]');

        function selectPeriod(period) {
            // Remove active class from all timeline items
            timelineItems.forEach(timelineItem => {
                timelineItem.classList.remove('active');
            });

            // Add active class to corresponding timeline item
            const correspondingTimelineItem = document.querySelector(`.timeline-item[data-period="${period}"]`);
            if (correspondingTimelineItem) {
                correspondingTimelineItem.classList.add('active');
            }

            // Update current period
            currentPeriod = period;

            // If period is null, show all markers, otherwise filter by period
            if (period === null) {
                showAllMarkers();
                console.log('Showing all markers from all periods');
            } else {
                createMarkersForPeriod(period);
                console.log('Selected period:', period, 'Markers count:', timelineData[period].length);
            }
        }

        // Timeline click events
        timelineItems.forEach(item => {
            item.addEventListener('click', function() {
                const period = this.getAttribute('data-period');
                selectPeriod(period);
            });
        });

        // Menu click events
        menuItems.forEach(item => {
            item.addEventListener('click', function(e) {
                e.preventDefault();
                const period = this.getAttribute('data-period');
                const periodValue = period === 'null' ? null : period;

                // Update active state for menu items
                menuItems.forEach(menuItem => {
                    menuItem.classList.remove('active');
                });
                this.classList.add('active');

                selectPeriod(periodValue);
            });
        });

        // Video player functionality
        document.addEventListener("DOMContentLoaded", function() {
            var playBtn = document.getElementById('play-btn-1');
            if (playBtn) {
                playBtn.addEventListener("click", function() {
                    var placeholder = document.getElementById('video-placeholder-1');
                    var videoSrc = placeholder.getAttribute("data-src");
                    var containerWidth = placeholder.offsetWidth;
                    var aspectRatio = 16 / 9;
                    var calculatedHeight = containerWidth / aspectRatio;

                    placeholder.innerHTML =
                        '<iframe src="' +
                        videoSrc +
                        '" width="100%" height="' +
                        calculatedHeight +
                        '" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen style="display:block; border-top:3px solid #000; border-bottom:3px solid #000;"></iframe>';
                });
            }
        });

        // Control body scroll when offcanvas opens/closes
        document.addEventListener('DOMContentLoaded', function() {
            const offcanvas = document.getElementById('markerOffcanvas');

            if (offcanvas) {
                // Store the current scroll position
                let scrollPosition = 0;

                // When offcanvas is about to show
                offcanvas.addEventListener('show.bs.offcanvas', function() {
                    // Store current scroll position
                    scrollPosition = window.pageYOffset || document.documentElement.scrollTop;

                    // Add class to disable scroll
                    document.body.classList.add('offcanvas-open');
                    document.body.style.top = -scrollPosition + 'px';
                });

                // When offcanvas is hidden
                offcanvas.addEventListener('hidden.bs.offcanvas', function() {
                    // Remove class to enable scroll
                    document.body.classList.remove('offcanvas-open');
                    document.body.style.top = '';

                    // Restore scroll position
                    window.scrollTo(0, scrollPosition);
                });
            }
        });
    </script>
@endpush
