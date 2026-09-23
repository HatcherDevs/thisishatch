(function () {
    function initProjectVideo() {
        const video = document.getElementById('pd2Video');
        const playButton = document.getElementById('pd2PlayBtn');

        const poster = document.getElementById('pd2VideoPoster');
        const embed = document.getElementById('pd2VideoEmbed');
        const iframe = document.getElementById('pd2VideoIframe');

        if (!playButton) {
            return;
        }

        const videoId = document.body.dataset.projectVideoId;
        const videoProvider = document.body.dataset.projectVideoProvider;

        playButton.addEventListener('click', function () {
            if (video) {
                video.play().catch(function (error) {
                    console.warn(
                        'Project video playback failed:',
                        error
                    );
                });

                playButton.setAttribute('aria-hidden', 'true');
                playButton.classList.add('is-hidden');

                return;
            }

            if (!poster || !embed || !iframe) {
                return;
            }

            let embedUrl = '';

            if (videoProvider === 'youtube') {
                embedUrl =
                    'https://www.youtube.com/embed/' +
                    videoId +
                    '?autoplay=1&rel=0';
            }

            if (videoProvider === 'vimeo') {
                embedUrl =
                    'https://player.vimeo.com/video/' +
                    videoId +
                    '?autoplay=1';
            }

            if (!embedUrl) {
                return;
            }

            iframe.src = embedUrl;

            poster.classList.add('d-none');
            embed.classList.remove('d-none');
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener(
            'DOMContentLoaded',
            initProjectVideo,
            { once: true }
        );
    } else {
        initProjectVideo();
    }
})();