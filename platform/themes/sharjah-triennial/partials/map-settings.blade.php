@php
    $pageId = $model->id ?? 0;
    $mapPoints = get_field('map_points', $pageId) ?: [];
    $mapCenter = get_field('map_center', $pageId) ?: '';
    $mapZoom = get_field('map_zoom', $pageId) ?: 12;
@endphp

<div class="alert alert-info">
    <i class="ti ti-info-circle me-2"></i>
    {{ __('Configure custom map points for this page. If no points are added, child pages will be used as map locations.') }}
</div>

<div id="map-settings-container" style="{{ (old('template', $model->template ?? '') === 'map-header') ? '' : 'display: none;' }}">
    <div class="row">
        <!-- Map Center -->
        <div class="col-md-6 mb-3">
            <label class="form-label">
                <i class="ti ti-target me-2"></i>
                {{ __('Map Center (Latitude, Longitude)') }}
            </label>
            <input type="text" 
                   name="map_center" 
                   class="form-control" 
                   value="{{ old('map_center', $mapCenter) }}" 
                   placeholder="25.3463, 55.4209"
                   data-counter="255">
            <small class="form-text text-muted">
                {{ __('Enter the center coordinates for the map. Example: 25.3463, 55.4209') }}
            </small>
        </div>

        <!-- Map Zoom -->
        <div class="col-md-6 mb-3">
            <label class="form-label">
                <i class="ti ti-zoom-in me-2"></i>
                {{ __('Map Zoom Level') }}
            </label>
            <input type="number" 
                   name="map_zoom" 
                   class="form-control" 
                   value="{{ old('map_zoom', $mapZoom) }}" 
                   min="1" 
                   max="20" 
                   placeholder="12">
            <small class="form-text text-muted">
                {{ __('Zoom level from 1 (world view) to 20 (street level). Default: 12') }}
            </small>
        </div>

        <!-- Map Points Section -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="ti ti-map-pins me-2"></i>
                        {{ __('Custom Map Points') }}
                    </h5>
                </div>
                <div class="card-body">
                    <div id="map-points-container">
                        @if(!empty($mapPoints) && is_array($mapPoints))
                            @foreach($mapPoints as $index => $point)
                                <div class="map-point-item border rounded p-3 mb-3 bg-light" data-index="{{ $index }}">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="mb-0">
                                            <i class="ti ti-map-pin me-2"></i>
                                            {{ __('Map Point') }} #{{ $index + 1 }}
                                        </h6>
                                        <button type="button" class="btn btn-sm btn-outline-danger remove-map-point">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">{{ __('Point Title') }} <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   name="map_points[{{ $index }}][title]" 
                                                   class="form-control" 
                                                   value="{{ old('map_points.' . $index . '.title', $point['title'] ?? '') }}" 
                                                   placeholder="{{ __('Enter point title') }}"
                                                   required>
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label class="form-label">{{ __('Description') }}</label>
                                            <textarea name="map_points[{{ $index }}][description]" 
                                                      class="form-control" 
                                                      rows="2"
                                                      placeholder="{{ __('Brief description') }}">{{ old('map_points.' . $index . '.description', $point['description'] ?? '') }}</textarea>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">{{ __('Latitude') }} <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   name="map_points[{{ $index }}][latitude]" 
                                                   class="form-control" 
                                                   value="{{ old('map_points.' . $index . '.latitude', $point['latitude'] ?? '') }}" 
                                                   placeholder="25.3463"
                                                   required>
                                        </div>
                                        <div class="col-md-3 mb-2">
                                            <label class="form-label">{{ __('Longitude') }} <span class="text-danger">*</span></label>
                                            <input type="text" 
                                                   name="map_points[{{ $index }}][longitude]" 
                                                   class="form-control" 
                                                   value="{{ old('map_points.' . $index . '.longitude', $point['longitude'] ?? '') }}" 
                                                   placeholder="55.4209"
                                                   required>
                                        </div>
                                        <div class="col-md-4 mb-2">
                                            <label class="form-label">{{ __('Link URL') }}</label>
                                            <input type="url" 
                                                   name="map_points[{{ $index }}][link_url]" 
                                                   class="form-control" 
                                                   value="{{ old('map_points.' . $index . '.link_url', $point['link_url'] ?? '') }}" 
                                                   placeholder="https://example.com">
                                        </div>
                                        <div class="col-md-2 mb-2">
                                            <label class="form-label">{{ __('Visible') }}</label>
                                            <select name="map_points[{{ $index }}][is_visible]" class="form-select">
                                                <option value="1" {{ old('map_points.' . $index . '.is_visible', $point['is_visible'] ?? '1') == '1' ? 'selected' : '' }}>{{ __('Yes') }}</option>
                                                <option value="0" {{ old('map_points.' . $index . '.is_visible', $point['is_visible'] ?? '1') == '0' ? 'selected' : '' }}>{{ __('No') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    
                    <div class="text-center mt-3">
                        <button type="button" class="btn btn-primary" id="add-map-point">
                            <i class="ti ti-plus me-2"></i>{{ __('Add New Map Point') }}
                        </button>
                    </div>
                    
                    @if(empty($mapPoints))
                        <div class="text-center text-muted mt-3" id="no-points-message">
                            <i class="ti ti-map-off display-6"></i>
                            <p class="mt-2">{{ __('No map points added yet. Click "Add New Map Point" to start.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
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
    document.getElementById('add-map-point').addEventListener('click', function() {
        const container = document.getElementById('map-points-container');
        const noPointsMessage = document.getElementById('no-points-message');
        
        if (noPointsMessage) {
            noPointsMessage.style.display = 'none';
        }
        
        const newPoint = `
            <div class="map-point-item border rounded p-3 mb-3 bg-light" data-index="${mapPointIndex}">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">
                        <i class="ti ti-map-pin me-2"></i>
                        {{ __('Map Point') }} #${mapPointIndex + 1}
                    </h6>
                    <button type="button" class="btn btn-sm btn-outline-danger remove-map-point">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <label class="form-label">{{ __('Point Title') }} <span class="text-danger">*</span></label>
                        <input type="text" name="map_points[${mapPointIndex}][title]" class="form-control" placeholder="{{ __('Enter point title') }}" required>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label class="form-label">{{ __('Description') }}</label>
                        <textarea name="map_points[${mapPointIndex}][description]" class="form-control" rows="2" placeholder="{{ __('Brief description') }}"></textarea>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label">{{ __('Latitude') }} <span class="text-danger">*</span></label>
                        <input type="text" name="map_points[${mapPointIndex}][latitude]" class="form-control" placeholder="25.3463" required>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="form-label">{{ __('Longitude') }} <span class="text-danger">*</span></label>
                        <input type="text" name="map_points[${mapPointIndex}][longitude]" class="form-control" placeholder="55.4209" required>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label class="form-label">{{ __('Link URL') }}</label>
                        <input type="url" name="map_points[${mapPointIndex}][link_url]" class="form-control" placeholder="https://example.com">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label class="form-label">{{ __('Visible') }}</label>
                        <select name="map_points[${mapPointIndex}][is_visible]" class="form-select">
                            <option value="1" selected>{{ __('Yes') }}</option>
                            <option value="0">{{ __('No') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', newPoint);
        mapPointIndex++;
        
        // Add animation
        const newElement = container.lastElementChild;
        newElement.style.opacity = '0';
        newElement.style.transform = 'translateY(20px)';
        setTimeout(() => {
            newElement.style.transition = 'all 0.3s ease';
            newElement.style.opacity = '1';
            newElement.style.transform = 'translateY(0)';
        }, 10);
    });
    
    // Remove map point
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-map-point') || e.target.closest('.remove-map-point')) {
            const pointItem = e.target.closest('.map-point-item');
            if (pointItem) {
                // Animate removal
                pointItem.style.transition = 'all 0.3s ease';
                pointItem.style.opacity = '0';
                pointItem.style.transform = 'translateX(-100%)';
                setTimeout(() => {
                    pointItem.remove();
                    
                    // Show no points message if no points left
                    const remainingPoints = document.querySelectorAll('.map-point-item');
                    const noPointsMessage = document.getElementById('no-points-message');
                    if (remainingPoints.length === 0 && noPointsMessage) {
                        noPointsMessage.style.display = 'block';
                    }
                    
                    // Renumber remaining points
                    document.querySelectorAll('.map-point-item').forEach((item, index) => {
                        const title = item.querySelector('h6');
                        if (title) {
                            title.innerHTML = '<i class="ti ti-map-pin me-2"></i>{{ __('Map Point') }} #' + (index + 1);
                        }
                    });
                }, 300);
            }
        }
    });
});
</script>

<style>
.map-point-item {
    transition: all 0.3s ease;
    border-left: 4px solid #0d6efd !important;
}

.map-point-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.remove-map-point {
    transition: all 0.2s ease;
}

.remove-map-point:hover {
    transform: scale(1.1);
}

#map-settings-container .alert {
    border-left: 4px solid #0dcaf0;
}

.form-label {
    font-weight: 600;
    color: #495057;
}

.text-danger {
    color: #dc3545 !important;
}

.card {
    border: 1px solid #dee2e6;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
}

.card-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
}

#no-points-message {
    padding: 2rem;
}
</style>