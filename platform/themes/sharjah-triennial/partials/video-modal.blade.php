{{-- Video Modal --}}
<div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div id="videoContainer"
                    style="position: relative; width: 100%; padding-bottom: 56.25%; height: 0; overflow: hidden;">
                    <iframe id="videoFrame"
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: none;"
                        frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                        allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const videoButtons = document.querySelectorAll('[data-video-type]');
        const videoModal = new bootstrap.Modal(document.getElementById('videoModal'));
        const videoFrame = document.getElementById('videoFrame');

        videoButtons.forEach(button => {
            button.addEventListener('click', function() {
                const embedUrl = this.getAttribute('data-embed-url');
                videoFrame.src = embedUrl;
                videoModal.show();
            });
        });

        // Clear video when modal closes
        document.getElementById('videoModal').addEventListener('hidden.bs.modal', function() {
            videoFrame.src = '';
        });
    });
</script>
