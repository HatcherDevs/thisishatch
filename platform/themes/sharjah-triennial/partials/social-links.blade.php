<!-- Social Links -->
<div class="social-links mt-3">
    @if($facebook = theme_option('social_facebook'))
        <a href="{{ $facebook }}" class="social-link me-2" target="_blank" rel="noopener noreferrer" title="Facebook">
            <i class="fab fa-facebook"></i>
        </a>
    @endif

    @if($twitter = theme_option('social_twitter'))
        <a href="{{ $twitter }}" class="social-link me-2" target="_blank" rel="noopener noreferrer" title="Twitter">
            <i class="fab fa-twitter"></i>
        </a>
    @endif

    @if($instagram = theme_option('social_instagram'))
        <a href="{{ $instagram }}" class="social-link me-2" target="_blank" rel="noopener noreferrer" title="Instagram">
            <i class="fab fa-instagram"></i>
        </a>
    @endif

    @if($linkedin = theme_option('social_linkedin'))
        <a href="{{ $linkedin }}" class="social-link me-2" target="_blank" rel="noopener noreferrer" title="LinkedIn">
            <i class="fab fa-linkedin"></i>
        </a>
    @endif

    @if($youtube = theme_option('social_youtube'))
        <a href="{{ $youtube }}" class="social-link me-2" target="_blank" rel="noopener noreferrer" title="YouTube">
            <i class="fab fa-youtube"></i>
        </a>
    @endif
</div>