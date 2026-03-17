@php
    $pageId = $model->id ?? 0;
    $mapPoints = get_field('map_points', $pageId) ?: [];
    $mapCenter = get_field('map_center', $pageId) ?: '';
    $mapZoom = get_field('map_zoom', $pageId) ?: 12;
@endphp

<div class="row" id="map-settings-container"
    style="{{ (old('template', $model->template ?? '') === 'map-header') ? '' : 'display: none;' }}">
    <div class="col-12">
        <div class="alert alert-info">
            <i class="ti ti-info-circle me-2"></i>
            {{ __('Configure custom map points for this page. If no points are added, child pages will be used as map locations.') }}
        </div>
    </div>

    <div class="col-12">
        <div class="form-group mb-3">
            <label class="form-label">
                <i class="ti ti-target me-2"></i>
                {{ __('Map Center (Latitude, Longitude)') }}
            </label>
            <input type="text" name="map_center" class="form-control" value="{{ old('map_center', $mapCenter) }}"
                placeholder="25.3463, 55.4209" data-counter="255">
            <small class="form-text text-muted">
                {{ __('Enter the center coordinates for the map. Example: 25.3463, 55.4209') }}
            </small>
        </div>
    </div>

    <div class="col-12">
        <div class="form-group mb-3">
            <label class="form-label">
                <i class="ti ti-zoom-in me-2"></i>
                {{ __('Map Zoom Level') }}
            </label>
            <input type="number" name="map_zoom" class="form-control" value="{{ old('map_zoom', $mapZoom) }}" min="1"
                max="20" placeholder="12">
            <small class="form-text text-muted">
                {{ __('Zoom level from 1 (world view) to 20 (street level). Default: 12') }}
            </small>
        </div>
    </div>

    <div class="col-12">
        <div class="form-group mb-3">
            <label class="form-label">
                <i class="ti ti-map-pins me-2"></i>
                {{ __('Custom Map Points') }}
            </label>
            <div id="map-points-container">
                @if(!empty($mapPoints) && is_array($mapPoints))
                    @foreach($mapPoints as $index => $point)
                        <div class="map-point-item border rounded p-3 mb-3" data-index="{{ $index }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label class="form-label">{{ __('Point Title') }}</label>
                                        <input type="text" name="map_points[{{ $index }}][title]" class="form-control"
                                            value="{{ old('map_points.' . $index . '.title', $point['title'] ?? '') }}"
                                            placeholder="{{ __('Enter point title') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-2">
                                        <label class="form-label">{{ __('Description') }}</label>
                                        <input type="text" name="map_points[{{ $index }}][description]" class="form-control"
                                            value="{{ old('map_points.' . $index . '.description', $point['description'] ?? '') }}"
                                            placeholder="{{ __('Brief description') }}">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-2">
                                        <label class="form-label">{{ __('Latitude') }}</label>
                                        <input type="text" name="map_points[{{ $index }}][latitude]" class="form-control"
                                            value="{{ old('map_points.' . $index . '.latitude', $point['latitude'] ?? '') }}"
                                            placeholder="25.3463">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group mb-2">
                                        <label class="form-label">{{ __('Longitude') }}</label>
                                        <input type="text" name="map_points[{{ $index }}][longitude]" class="form-control"
                                            value="{{ old('map_points.' . $index . '.longitude', $point['longitude'] ?? '') }}"
                                            placeholder="55.4209">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-2">
                                        <label class="form-label">{{ __('Link URL') }}</label>
                                        <input type="url" name="map_points[{{ $index }}][link_url]" class="form-control"
                                            value="{{ old('map_points.' . $index . '.link_url', $point['link_url'] ?? '') }}"
                                            placeholder="https://example.com">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group mb-2">
                                        <label class="form-label">{{ __('Visible') }}</label>
                                        <select name="map_points[{{ $index }}][is_visible]" class="form-control">
                                            <option value="1" {{ old('map_points.' . $index . '.is_visible', $point['is_visible'] ?? '1') == '1' ? 'selected' : '' }}>{{ __('Yes') }}</option>
                                            <option value="0" {{ old('map_points.' . $index . '.is_visible', $point['is_visible'] ?? '1') == '0' ? 'selected' : '' }}>{{ __('No') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <button type="button" class="btn btn-sm btn-danger remove-map-point">
                                    <i class="ti ti-trash me-1"></i>{{ __('Remove Point') }}
                                </button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="text-center">
                <button type="button" class="btn btn-primary" id="add-map-point">
                    <i class="ti ti-plus me-2"></i>{{ __('Add Map Point') }}
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let mapPointIndex = {{ count($mapPoints ?? []) }};

        // Show/hide map settings based on template selection
        function toggleMapSettings() {
            const templateSelect = document.querySelector('select[name="template"]');
            const mapContainer = document.getElementById('map-settings-container');

            if (templateSelect && mapContainer) {
                if (templateSelect.value === 'map-header') {
                    mapContainer.style.display = '';
                } else {
                    mapContainer.style.display = 'none';
                }
            }
        }

        // Listen for template changes
        const templateSelect = document.querySelector('select[name="template"]');
        if (templateSelect) {
            templateSelect.addEventListener('change', toggleMapSettings);
            toggleMapSettings(); // Initial check
        }

        // Add new map point
        document.getElementById('add-map-point').addEventListener('click', function () {
            const container = document.getElementById('map-points-container');
            const newPoint = `
            <div class="map-point-item border rounded p-3 mb-3" data-index="${mapPointIndex}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label class="form-label">{{ __('Point Title') }}</label>
                            <input type="text" name="map_points[${mapPointIndex}][title]" class="form-control" placeholder="{{ __('Enter point title') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-2">
                            <label class="form-label">{{ __('Description') }}</label>
                            <input type="text" name="map_points[${mapPointIndex}][description]" class="form-control" placeholder="{{ __('Brief description') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-2">
                            <label class="form-label">{{ __('Latitude') }}</label>
                            <input type="text" name="map_points[${mapPointIndex}][latitude]" class="form-control" placeholder="25.3463">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group mb-2">
                            <label class="form-label">{{ __('Longitude') }}</label>
                            <input type="text" name="map_points[${mapPointIndex}][longitude]" class="form-control" placeholder="55.4209">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-2">
                            <label class="form-label">{{ __('Link URL') }}</label>
                            <input type="url" name="map_points[${mapPointIndex}][link_url]" class="form-control" placeholder="https://example.com">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mb-2">
                            <label class="form-label">{{ __('Visible') }}</label>
                            <select name="map_points[${mapPointIndex}][is_visible]" class="form-control">
                                <option value="1" selected>{{ __('Yes') }}</option>
                                <option value="0">{{ __('No') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <button type="button" class="btn btn-sm btn-danger remove-map-point">
                        <i class="ti ti-trash me-1"></i>{{ __('Remove Point') }}
                    </button>
                </div>
            </div>
        `;
            container.insertAdjacentHTML('beforeend', newPoint);
            mapPointIndex++;
        });

        // Remove map point
        document.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-map-point') || e.target.closest('.remove-map-point')) {
                const pointItem = e.target.closest('.map-point-item');
                if (pointItem) {
                    pointItem.remove();
                }
            }
        });
    });
</script>

<style>
    .map-point-item {
        background-color: #f8f9fa;
        transition: all 0.3s ease;
    }

    .map-point-item:hover {
        background-color: #e9ecef;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    #map-settings-container .alert {
        border-left: 4px solid #0d6efd;
    }

    .remove-map-point {
        transition: all 0.3s ease;
    }

    .remove-map-point:hover {
        transform: scale(1.05);
    }
</style>