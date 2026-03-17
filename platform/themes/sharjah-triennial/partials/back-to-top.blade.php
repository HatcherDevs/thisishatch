<!-- Back to Top Button -->
<button type="button" id="back-to-top" class="back-to-top" title="{{ __('Back to Top') }}"
    aria-label="{{ __('Back to Top') }}">
    <i class="fas fa-chevron-up"></i>
</button>

<style>
    .back-to-top {
        position: fixed;
        bottom: 30px;
        right: 30px;
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #0f3460 0%, #1a1a2e 100%);
        color: #fff;
        border: none;
        border-radius: 50%;
        display: none;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        z-index: 999;
        cursor: pointer;
        transition: all 0.3s ease;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
    }

    .back-to-top:hover {
        background: linear-gradient(135deg, #1a1a2e 0%, #0f3460 100%);
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
    }

    .back-to-top.show {
        display: flex;
        animation: fadeInUp 0.3s ease;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @media (max-width: 768px) {
        .back-to-top {
            bottom: 20px;
            right: 20px;
            width: 45px;
            height: 45px;
            font-size: 18px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const backToTop = document.getElementById('back-to-top');

        if (backToTop) {
            // Show/hide button on scroll
            window.addEventListener('scroll', function () {
                if (window.pageYOffset > 300) {
                    backToTop.classList.add('show');
                } else {
                    backToTop.classList.remove('show');
                }
            });

            // Smooth scroll to top
            backToTop.addEventListener('click', function (e) {
                e.preventDefault();
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        }
    });
</script>