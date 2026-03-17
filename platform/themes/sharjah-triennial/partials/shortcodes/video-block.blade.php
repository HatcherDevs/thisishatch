@php
    use Botble\Media\Facades\RvMedia;

    $videoUrl = $shortcode->video_url;
    $title = $shortcode->title;
    $description = $shortcode->description;
    $previewImage = $shortcode->preview_image;

    // Generate unique ID for this video block
    $uniqueId = 'video-' . uniqid();

    // Convert YouTube/Vimeo URLs to embed URLs
    $embedUrl = null;
    $videoId = null;

    if (str_contains($videoUrl, 'youtube.com') || str_contains($videoUrl, 'youtu.be')) {
        // Extract YouTube video ID
        preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $videoUrl, $matches);
        if (!empty($matches[1])) {
            $videoId = $matches[1];
            $embedUrl = 'https://www.youtube.com/embed/' . $videoId . '?autoplay=1';
            // Default YouTube thumbnail if no preview image provided
            if (empty($previewImage)) {
                $previewImage = 'https://img.youtube.com/vi/' . $videoId . '/maxresdefault.jpg';
            }
        }
    } elseif (str_contains($videoUrl, 'vimeo.com')) {
        // Extract Vimeo video ID
        preg_match('/vimeo\.com\/(?:channels\/(?:\w+\/)?|groups\/(?:[^\/]*)\/videos\/|album\/(?:\d+)\/video\/|)(\d+)(?:$|\/|\?)/', $videoUrl, $matches);
        if (!empty($matches[1])) {
            $videoId = $matches[1];
            $embedUrl = 'https://player.vimeo.com/video/' . $videoId . '?autoplay=1';
        }
    }

    // Get the preview image URL from media library
    if ($previewImage) {
        $previewImage = RvMedia::getImageUrl($previewImage);
    } elseif (empty($previewImage) && !$videoId) {
        $previewImage = 'https://via.placeholder.com/1920x1080/000000/FFFFFF/?text=Video+Preview';
    }
@endphp

<!-- Video Section -->
<div class="video-section mb-3" style="position: relative; max-width: 100%;">
    @if($embedUrl)
        <div id="{{ $uniqueId }}-placeholder" data-src="{{ $embedUrl }}"
            style="position: relative; display: inline-block; width: 100%;">
            <img id="{{ $uniqueId }}-preview-img" src="{{ $previewImage }}" alt="{{ $title ?: 'video preview' }}"
                style="width: 100%; display: block; object-fit: cover;" />
            <button id="{{ $uniqueId }}-play-btn" type="button" style="
                        position: absolute;
                        left: 50%;
                        top: 50%;
                        transform: translate(-50%, -50%);
                        background: #fff;
                        border: 3px solid #222;
                        border-radius: 4px;
                        width: 70px;
                        height: 70px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        cursor: pointer;
                        transition: all 0.3s ease;
                    " onmouseover="this.style.transform='translate(-50%, -50%) scale(1.1)'"
                onmouseout="this.style.transform='translate(-50%, -50%) scale(1)'">
                <svg width="40" height="40" viewBox="0 0 40 40">
                    <polygon points="12,8 32,20 12,32" fill="#222" />
                </svg>
            </button>
        </div>
    @else
        <div class="alert alert-warning" style="text-align: center; padding: 2rem;">
            {{ __('Invalid video URL. Please enter a valid YouTube or Vimeo URL.') }}
        </div>
    @endif

    @if($title)
        <div class="fw-normal mb-3 mt-2" style="font-size: 16px;">
            {{ $title }}
        </div>
        <hr class="m-0 mb-2" style="border: none; border-top: 3px solid #000; width: 100%;" />
    @endif
</div>

@if($description)
    <p class="mb-4" style="line-height: normal;">
        {!! nl2br(e($description)) !!}
    </p>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const playBtn = document.getElementById('{{ $uniqueId }}-play-btn');
        const placeholder = document.getElementById('{{ $uniqueId }}-placeholder');

        if (playBtn && placeholder) {
            playBtn.addEventListener('click', function () {
                const videoSrc = placeholder.getAttribute('data-src');
                const iframe = document.createElement('iframe');

                iframe.setAttribute('src', videoSrc);
                iframe.setAttribute('frameborder', '0');
                iframe.setAttribute('allow', 'accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture');
                iframe.setAttribute('allowfullscreen', 'true');
                iframe.style.width = '100%';
                iframe.style.height = '100%';
                iframe.style.position = 'absolute';
                iframe.style.top = '0';
                iframe.style.left = '0';

                // Make placeholder responsive
                placeholder.style.paddingBottom = '56.25%'; // 16:9 aspect ratio
                placeholder.style.height = '0';
                placeholder.style.position = 'relative';

                // Replace content with iframe
                placeholder.innerHTML = '';
                placeholder.appendChild(iframe);
            });
        }
    });
</script>