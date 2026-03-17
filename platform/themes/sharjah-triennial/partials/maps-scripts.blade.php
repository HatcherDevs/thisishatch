{{-- Mapbox GL JS Integration --}}
<link href='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.css' rel='stylesheet' />
<script src='https://api.mapbox.com/mapbox-gl-js/v2.15.0/mapbox-gl.js'></script>

{{-- Header Map Script --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var headerMapElement = document.getElementById('visit-us-map');
        if (!headerMapElement) {
            return;
        }

        mapboxgl.accessToken =
            'pk.eyJ1IjoiYWJkZWxyaG1hbmF0d2EzOSIsImEiOiJjbWQyZTZoZGMxN280Mmxxd3d3NWw1aHMyIn0.YcekKacapqijA-aHi_hkgg';

        var defaultLat =
            {{ $headerMapCenterLatitude && is_numeric($headerMapCenterLatitude) ? $headerMapCenterLatitude : 25.3463 }};
        var defaultLng =
            {{ $headerMapCenterLongitude && is_numeric($headerMapCenterLongitude) ? $headerMapCenterLongitude : 55.4209 }};
        var defaultZoom = {{ $headerMapZoom && is_numeric($headerMapZoom) ? $headerMapZoom : 12 }};

        var map = new mapboxgl.Map({
            container: 'visit-us-map',
            style: 'mapbox://styles/mapbox/light-v11',
            center: [defaultLng, defaultLat],
            zoom: defaultZoom,
            interactive: true
        });

        var locations = [
            @if ($visibleHeaderMapPoints->isNotEmpty())
                @foreach ($visibleHeaderMapPoints as $point)
                    @php
                        $lat = floatval($point['latitude'] ?? 25.3463);
                        $lng = floatval($point['longitude'] ?? 55.4209);

                        if ($lat < -90 || $lat > 90) {
                            $lat = 25.3463;
                        }
                        if ($lng < -180 || $lng > 180) {
                            $lng = 55.4209;
                        }
                    @endphp {
                        name: {!! json_encode($point['title']) !!},
                        lat: {{ $lat }},
                        lng: {{ $lng }},
                        url: {!! json_encode($point['link_url'] ?? '#') !!},
                        description: {!! json_encode($point['description'] ?? '') !!}
                    }
                    @if (!$loop->last)
                        ,
                    @endif
                @endforeach
            @else
                {
                    name: {!! json_encode($pageData->name ?? 'Main Location') !!},
                    lat: defaultLat,
                    lng: defaultLng,
                    url: "#",
                    description: {!! json_encode($pageData->description ?? 'Main location description') !!}
                }
            @endif
        ];

        var markersData = [];

        locations.forEach(function(location, index) {
            const markerElement = document.createElement('div');
            markerElement.style.width = '32px';
            markerElement.style.height = '32px';
            markerElement.style.border = '3px solid #000';
            markerElement.style.borderRadius = '50%';
            markerElement.style.background = index === 0 ? 'transparent' : '#fff';
            markerElement.style.boxSizing = 'border-box';
            markerElement.style.cursor = 'pointer';
            markerElement.classList.add('dynamic-map-marker');

            markerElement.addEventListener('mouseenter', () => {
                markerElement.style.background = '#000';
            });

            markerElement.addEventListener('mouseleave', () => {
                markerElement.style.background = 'transparent';
            });

            var marker = new mapboxgl.Marker(markerElement)
                .setLngLat([location.lng, location.lat])
                .addTo(map);

            var popup = new mapboxgl.Popup({
                    offset: 25
                })
                .setHTML(`
                    <div class="map-popup">
                        <h6><strong>${location.name}</strong></h6>
                        <p class="mb-2">${location.description}</p>
                        ${location.url && location.url !== '#' ? `<a href="${location.url}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-primary">
                                <i class="fa fa-external-link-alt me-1"></i>
                                Visit Location
                            </a>` : ''}
                    </div>
                `);

            markerElement.addEventListener('click', function(e) {
                e.stopPropagation();

                if (location.url && location.url !== '#') {
                    window.open(location.url, '_blank');
                } else {
                    popup.addTo(map);
                    map.flyTo({
                        center: [location.lng, location.lat],
                        zoom: 15,
                        duration: 1000
                    });
                }
            });

            markersData.push({
                name: location.name,
                marker: marker,
                popup: popup,
                lat: location.lat,
                lng: location.lng
            });
        });

        if (locations.length > 1) {
            const bounds = new mapboxgl.LngLatBounds();
            locations.forEach(location => {
                bounds.extend([location.lng, location.lat]);
            });
            map.fitBounds(bounds, {
                padding: 50
            });
        }

        window.headerMapInstance = map;
        window.headerMapMarkers = markersData;
    });
</script>

{{-- Sidebar Map Script --}}
@if ($showMap)
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var sidebarMapElement = document.getElementById('al-qasimiyah-map');
            if (!sidebarMapElement) {
                return;
            }

            mapboxgl.accessToken =
                'pk.eyJ1IjoiYWJkZWxyaG1hbmF0d2EzOSIsImEiOiJjbWQyZTZoZGMxN280Mmxxd3d3NWw1aHMyIn0.YcekKacapqijA-aHi_hkgg';

            var sidedefaultLat = {{ $sidedefaultLat }};
            var sidedefaultLng = {{ $sidedefaultLng }};
            var sidedefaultZoom = {{ $sidedefaultZoom }};

            var sidebarMap = new mapboxgl.Map({
                container: 'al-qasimiyah-map',
                style: 'mapbox://styles/mapbox/light-v11',
                center: [sidedefaultLng, sidedefaultLat],
                zoom: sidedefaultZoom,
                interactive: true
            });

            var sidebarLocations = [
                @if ($sidevisibleMapPoints->isNotEmpty())
                    @foreach ($sidevisibleMapPoints as $point)
                        @php
                            $lat = floatval($point['latitude'] ?? $sidedefaultLat);
                            $lng = floatval($point['longitude'] ?? $sidedefaultLng);
                            if ($lat < -90 || $lat > 90) {
                                $lat = $sidedefaultLat;
                            }
                            if ($lng < -180 || $lng > 180) {
                                $lng = $sidedefaultLng;
                            }
                        @endphp {
                            name: {!! json_encode($point['title']) !!},
                            lat: {{ $lat }},
                            lng: {{ $lng }},
                            url: {!! json_encode($point['link_url'] ?? '#') !!},
                            description: {!! json_encode($point['description'] ?? '') !!}
                        }
                        @if (!$loop->last)
                            ,
                        @endif
                    @endforeach
                @else
                    {
                        name: {!! json_encode($pageData->name ?? 'Main Location') !!},
                        lat: sidedefaultLat,
                        lng: sidedefaultLng,
                        url: "#",
                        description: {!! json_encode($pageData->description ?? 'Main location description') !!}
                    }
                @endif
            ];

            var sidebarMarkersData = [];

            sidebarLocations.forEach(function(location, index) {
                const sidemarkerElement = document.createElement('div');
                sidemarkerElement.style.width = '32px';
                sidemarkerElement.style.height = '32px';
                sidemarkerElement.style.border = '3px solid #000';
                sidemarkerElement.style.borderRadius = '50%';
                sidemarkerElement.style.background = index === 0 ? 'transparent' : '#fff';
                sidemarkerElement.style.boxSizing = 'border-box';
                sidemarkerElement.style.cursor = 'pointer';
                sidemarkerElement.classList.add('dynamic-map-marker');

                var sidebarMarker = new mapboxgl.Marker(sidemarkerElement)
                    .setLngLat([location.lng, location.lat])
                    .addTo(sidebarMap);

                var sidebarPopup = new mapboxgl.Popup({
                        offset: 25
                    })
                    .setHTML(`
                    <div class="map-popup">
                        <h6><strong>${location.name}</strong></h6>
                        <p class="mb-2">${location.description}</p>
                        ${location.url && location.url !== '#' ? `<a href="${location.url}" target="_blank" rel="noopener noreferrer" class="btn btn-sm btn-primary">
                                        <i class="fa fa-external-link-alt me-1"></i>
                                        Visit Location
                                    </a>` : ''}
                    </div>
                `);

                sidemarkerElement.addEventListener('click', function(e) {
                    e.stopPropagation();

                    if (location.url && location.url !== '#') {
                        window.open(location.url, '_blank');
                    } else {
                        sidebarPopup.addTo(sidebarMap);
                        sidebarMap.flyTo({
                            center: [location.lng, location.lat],
                            zoom: 15,
                            duration: 1000
                        });
                    }
                });

                sidebarMarkersData.push({
                    name: location.name,
                    marker: sidebarMarker,
                    popup: sidebarPopup,
                    lat: location.lat,
                    lng: location.lng
                });
            });

            if (sidebarLocations.length > 1) {
                const bounds = new mapboxgl.LngLatBounds();
                sidebarLocations.forEach(location => {
                    bounds.extend([location.lng, location.lat]);
                });
                sidebarMap.fitBounds(bounds, {
                    padding: 50
                });
            }

            window.sidebarMapInstance = sidebarMap;
            window.sidebarMapMarkers = sidebarMarkersData;
        });
    </script>
@endif
