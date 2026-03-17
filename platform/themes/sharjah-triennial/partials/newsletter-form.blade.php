<!-- Newsletter Form -->
<form class="footer-newsletter-form" action="{{ route('public.newsletter.subscribe') }}" method="POST">
    @csrf
    <input type="email" name="email" class="footer-newsletter-input"
        placeholder="{{ isArabic() ? 'عنوان البريد الإلكتروني' : 'Email address' }}" required />
    <button type="submit" class="footer-newsletter-btn">{{ isArabic() ? 'اشتراك' : 'Sign up' }}</button>
</form>
