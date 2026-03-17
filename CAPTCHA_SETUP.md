# 🔒 CAPTCHA Setup Guide

## Current Status

✅ CAPTCHA Plugin is activated
✅ CAPTCHA is enabled for Contact Forms
✅ CAPTCHA is enabled for Newsletter Forms
⚠️ Google reCAPTCHA keys not configured yet

## Setup Instructions

### 1. Get Google reCAPTCHA Keys

1. Visit https://www.google.com/recaptcha/admin/create
2. Choose reCAPTCHA v2 (Checkbox or Invisible)
3. Add your domains (e.g., sharjah-new.test, yourdomain.com)
4. Get your **Site Key** and **Secret Key**

### 2. Add Keys to .env

Add these lines to your `.env` file:

```env
CAPTCHA_TYPE=recaptcha
RECAPTCHA_SITE_KEY=your_site_key_here
RECAPTCHA_SECRET_KEY=your_secret_key_here
```

### 3. Update Database Settings

Run this SQL or update via Admin Panel:

```sql
INSERT INTO settings (`key`, `value`, created_at, updated_at) VALUES
('captcha_type', 'recaptcha', NOW(), NOW()),
('recaptcha_site_key', 'your_site_key_here', NOW(), NOW()),
('recaptcha_secret_key', 'your_secret_key_here', NOW(), NOW());
```

### 4. Admin Panel Configuration

1. Login to Admin Panel: `/admin`
2. Go to **Settings** → **CAPTCHA**
3. Choose **reCAPTCHA v2**
4. Enter Site Key and Secret Key
5. Enable for desired forms:
    - ✅ Contact Form
    - ✅ Newsletter Form
    - Event Registration Form (if needed)

### 5. Test CAPTCHA

1. Visit contact form: `/contact`
2. Visit newsletter subscription
3. Verify reCAPTCHA widget appears
4. Submit forms to test validation

## Alternative: Math CAPTCHA

If you prefer simple math captcha instead of Google reCAPTCHA:

```env
CAPTCHA_TYPE=math
```

This uses simple arithmetic questions (e.g., "2 + 3 = ?") and doesn't require external API keys.

## Security Benefits

- ✅ Prevents automated bot submissions
- ✅ Reduces spam in contact forms
- ✅ Protects against DDoS via form abuse
- ✅ Complies with data protection standards (reCAPTCHA v3/v2 invisible)

## Verification

Check database to confirm CAPTCHA is enabled:

```sql
SELECT * FROM settings WHERE `key` LIKE '%captcha%' OR `key` LIKE '%recaptcha%';
```

Expected result:

- `enable_recaptcha_botble_contact_forms_fronts_contact_form` = 1
- `enable_recaptcha_botble_newsletter_forms_fronts_newsletter_form` = 1
- `captcha_type` = recaptcha
- `recaptcha_site_key` = your_key
- `recaptcha_secret_key` = your_secret
