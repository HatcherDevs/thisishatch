@php
    use Botble\Media\Facades\RvMedia;
    use Botble\Shortcode\Facades\Shortcode as ShortcodeFacade;

    $title = $shortcode->title;
    $description = $shortcode->description;

    // Get images data from tabs
    $images = ShortcodeFacade::fields()->getTabsData(['image', 'caption'], $shortcode);
@endphp

@if(!empty($images))
    @php
        $carouselId = 'imageGallery' . uniqid();
        $totalImages = count($images);
    @endphp

    <!-- Image Gallery Slider Section -->
    <div class="custom-slider mb-2" style="max-width: 100%">
        {{-- @if($title)
            <h2 class="gallery-title mb-3">{{ $title }}</h2>
        @endif --}}



        <div class="slider-img-wrap" style="position: relative">
            <div id="{{ $carouselId }}" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @foreach($images as $index => $image)
                        @php
                            $imageUrl = RvMedia::getImageUrl($image['image']);
                            $caption = $image['caption'] ?? '';
                        @endphp

                        @if($imageUrl)
                            <div class="carousel-item {{ $index === 0 ? 'active' : '' }}" data-caption="{{ $caption }}">
                                <img src="{{ $imageUrl }}" class="d-block w-100" alt="{{ $caption ?: 'Gallery image' }}"
                                    style="height: 500px; object-fit: cover; object-position: center; border-top: 3px solid #000; border-bottom: 3px solid #000;" />
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Zoom Icon -->
            <span class="slider-zoom" style="position: absolute; top: 10px; right: 10px; cursor: pointer;"
                onclick="openImageModal{{ $carouselId }}()">
                <i class="fa-solid fa-2x fa-expand bg-white" style="padding: 0px 2px; border-radius: 1px"></i>
            </span>
        </div>

        <!-- Slider Controls -->
        <div class="d-flex align-items-center justify-content-between" style="gap: 12px">
            <div>
                <span class="slider-count" style="font-size: 15px"
                    id="{{ $carouselId }}_counter">1/{{ $totalImages }}</span>
                <span class="slider-caption" style="font-size: 15px"
                    id="{{ $carouselId }}_caption">{{ $images[0]['caption'] ?? '' }}</span>
            </div>
            <div class="d-flex justify-content-between align-items-center" style="width: 10%">
                <button class="slider-prev slider-arrow" type="button" data-bs-target="#{{ $carouselId }}"
                    data-bs-slide="prev" style="background: none; border: none; font-size: 2rem; cursor: pointer;">
                    <i class="fa fa-arrow-left" style="font-size: 1.5rem"></i>
                </button>
                <button class="slider-next slider-arrow" type="button" data-bs-target="#{{ $carouselId }}"
                    data-bs-slide="next" style="background: none; border: none; font-size: 2rem; cursor: pointer;">
                    <i class="fa fa-arrow-right" style="font-size: 1.5rem"></i>
                </button>
            </div>
        </div>

        <hr class="m-0 mb-2" style="border: none; border-top: 3px solid #000; width: 100%;" />

                @if($description)
            <p class="gallery-description mb-4">{!! nl2br(e($description)) !!}</p>
        @endif

    </div>

    <!-- Modal for Full Screen Image -->
    <div class="modal fade" id="imageModal{{ $carouselId }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content" style="background: transparent; border: none;">
                <div class="modal-body p-0" style="position: relative;">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"
                        style="position: absolute; top: 10px; right: 10px; z-index: 1000;"></button>
                    <img id="modalImage{{ $carouselId }}" src="" class="w-100" alt="Full screen"
                        style="max-height: 90vh; object-fit: contain;" />
                </div>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const carousel = document.getElementById('{{ $carouselId }}');
            const counterEl = document.getElementById('{{ $carouselId }}_counter');
            const captionEl = document.getElementById('{{ $carouselId }}_caption');
            const totalImages = {{ $totalImages }};

            // Update counter and caption on slide change
            carousel.addEventListener('slid.bs.carousel', function (e) {
                const activeIndex = Array.from(e.target.querySelectorAll('.carousel-item')).indexOf(e.relatedTarget);
                const currentSlide = activeIndex + 1;
                counterEl.textContent = currentSlide + '/' + totalImages;

                const caption = e.relatedTarget.getAttribute('data-caption') || '';
                captionEl.textContent = caption;
            });

            // Open modal with current image
            window['openImageModal{{ $carouselId }}'] = function () {
                const activeItem = carousel.querySelector('.carousel-item.active img');
                const modalImage = document.getElementById('modalImage{{ $carouselId }}');
                const modal = new bootstrap.Modal(document.getElementById('imageModal{{ $carouselId }}'));

                modalImage.src = activeItem.src;
                modal.show();
            };
        })();
    </script>

@endif