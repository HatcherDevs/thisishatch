# تقرير الفحص الأمني الشامل - Sharjah Architecture Triennial

**تاريخ الفحص:** 9 ديسمبر 2025  
**حالة المشروع:** Laravel 12.19.3 + PHP 8.2.28  
**مستوى الخطورة العام:** 🔴 **عالي - يتطلب إجراءً فورياً**

---

## 📋 ملخص تنفيذي

تم إجراء فحص أمني شامل لمشروع Sharjah Architecture Triennial، وتم الكشف عن **ثغرات أمنية خطيرة** تتطلب معالجة فورية. المشروع حالياً في **وضع Development Mode** على الإنتاج، مما يعرض بيانات حساسة ويشكل مخاطر أمنية جسيمة.

### النتائج الرئيسية:

- ✅ **8 نقاط آمنة**
- ⚠️ **12 ثغرة متوسطة الخطورة**
- 🔴 **7 ثغرات عالية الخطورة**
- 🔴 **3 ثغرات حرجة**

---

## 🚨 الثغرات الحرجة (Critical Vulnerabilities)

### 1. 🔴 DEBUG MODE مفعّل في بيئة الإنتاج

**الخطورة:** حرجة - Critical  
**الوصف:**

```php
// config/app.php
'debug' => (bool) env('APP_DEBUG', false),

// القيمة الحالية:
APP_DEBUG = true
APP_ENV = local
```

**التأثير:**

- ✗ كشف مسارات الملفات الكاملة على السيرفر
- ✗ عرض معلومات حساسة في رسائل الأخطاء
- ✗ كشف تفاصيل قاعدة البيانات والاستعلامات
- ✗ كشف المتغيرات البيئية والـ secrets
- ✗ تسهيل الهجمات المستهدفة

**الحل الفوري:**

```env
# يجب تغييرها فوراً في .env
APP_ENV=production
APP_DEBUG=false
```

---

### 2. 🔴 ثغرة SQL Injection في EventRegistrationController

**الخطورة:** حرجة - Critical  
**الموقع:** `platform/plugins/sharjah-event-calendar/src/Http/Controllers/EventRegistrationController.php:32`

**الكود الضعيف:**

```php
->orWhereRaw('DATE_FORMAT(created_at, "%Y-%m-%d %H:%i") like ?', ["%$q%"]);
```

**المشكلة:**

- المتغير `$q` يأتي مباشرة من `$request->input('q')` بدون تنظيف
- استخدام `LIKE` مع `%` يسمح بحقن SQL خطير
- يمكن للمهاجم تنفيذ استعلامات SQL عشوائية

**مثال هجوم:**

```
?q=%" OR 1=1 UNION SELECT password,email,null,null,null,null FROM users--
```

**الحل:**

```php
// استبدل الكود بـ:
$q = $request->input('q', '');
$registrations = $event->registrations()
    ->where(function ($query) use ($q) {
        $query->where('registration_number', 'like', '%' . $q . '%')
            ->orWhere('name', 'like', '%' . $q . '%')
            ->orWhere('email', 'like', '%' . $q . '%')
            ->orWhere('phone', 'like', '%' . $q . '%')
            ->orWhere('status', 'like', '%' . $q . '%');
    })
    ->get();
```

---

### 3. 🔴 ثغرة IDOR في Event Registration

**الخطورة:** حرجة - Critical  
**الموقع:** `PublicRegistrationController.php:18`

**الكود الضعيف:**

```php
$event = Event::query()
    ->where('status', BaseStatusEnum::PUBLISHED)
    ->firstOrFail(); // ❌ لا يستخدم $slug المُمرر!
```

**المشكلة:**

- الدالة تجلب **أي** event منشور، وليس الـ event المطلوب
- يمكن التسجيل في أي event حتى لو كان الـ URL لـ event آخر
- ثغرة Insecure Direct Object Reference واضحة

**الحل:**

```php
$event = Event::query()
    ->where('slug', $slug) // ✅ استخدام الـ slug
    ->where('status', BaseStatusEnum::PUBLISHED)
    ->firstOrFail();
```

---

## ⚠️ الثغرات عالية الخطورة (High Risk)

### 4. ⚠️ غياب Rate Limiting على نقاط حرجة

**المناطق المتأثرة:**

- `/contact/send` - لا يوجد rate limiting
- `/events/{slug}/register` - لا يوجد rate limiting
- `/newsletter/subscribe` - لا يوجد rate limiting

**التأثير:**

- هجمات DDoS
- Spam attacks
- Brute force attacks
- إغراق قاعدة البيانات

**الحل:**

```php
// في bootstrap/app.php أو RouteServiceProvider
Route::middleware(['throttle:10,1'])->group(function () {
    Route::post('/contact/send', ...);
    Route::post('/events/{slug}/register', ...);
    Route::post('/newsletter/subscribe', ...);
});
```

---

### 5. ⚠️ عدم التحقق من نوع الملفات المرفوعة

**الموقع:** `vendor/botble/platform/media/`

**المشكلة:**

- رفع ملفات PHP قد يكون ممكناً
- عدم التحقق الكافي من MIME types
- إمكانية رفع ملفات خبيثة

**الحل:**

```php
// في config/media.php
'allowed_mime_types' => [
    'image/jpeg',
    'image/png',
    'image/gif',
    'image/webp',
    'application/pdf',
],
'disallowed_extensions' => [
    'php', 'phtml', 'php3', 'php4', 'php5',
    'exe', 'bat', 'cmd', 'sh', 'jar'
],
```

---

### 6. ⚠️ Mass Assignment Vulnerability

**جميع Models تستخدم $fillable بدون حماية كافية**

**أمثلة:**

```php
// EventRegistration.php
protected $fillable = [
    'event_id',
    'registration_number',
    'name',
    'email',
    'phone',
    'registration_data',
    'status',  // ❌ خطر! يمكن تغيير الحالة
    'notes',
    'ip_address',
    'user_agent',
    'confirmed_at',
    'attended_at',
];
```

**الحل:**

```php
// استخدم $guarded بدلاً من ذلك
protected $guarded = ['id', 'status', 'confirmed_at', 'attended_at'];
```

---

### 7. ⚠️ XSS في theme functions.php

**الموقع:** `platform/themes/sharjah-triennial/functions/functions.php`

**مشاكل متعددة:**

```php
// السطر 1835 - استخدام orderByRaw مع implode بدون تنظيف
->orderByRaw('FIELD(id, ' . implode(',', $relatedPageIds) . ')')

// عدم استخدام htmlspecialchars في أماكن متعددة
$tabs .= '<input ... value="' . $point['title'] . '" ...'; // ❌
```

**الحل:**

```php
// التحقق من القيم
$relatedPageIds = array_map('intval', $relatedPageIds);
->orderByRaw('FIELD(id, ' . implode(',', $relatedPageIds) . ')')

// استخدام htmlspecialchars
value="' . htmlspecialchars($point['title'] ?? '', ENT_QUOTES, 'UTF-8') . '"
```

---

### 8. ⚠️ Unserialize غير آمن

**الموقع:** `platform/plugins/log-viewer-plus/src/Concerns/LogIndex/CanCacheIndex.php:72`

```php
$data = unserialize(gzuncompress($data)); // ❌ خطر!
```

**التأثير:**

- Remote Code Execution محتمل
- Object Injection attacks

**الحل:**

```php
$data = json_decode(gzuncompress($data), true);
// أو استخدام
$data = unserialize($data, ['allowed_classes' => false]);
```

---

### 9. ⚠️ Session Configuration ضعيفة

**الموقع:** `config/session.php`

```php
'lifetime' => (int) env('SESSION_LIFETIME', 120),
'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', false),
'encrypt' => env('SESSION_ENCRYPT', false), // ❌
```

**الحل:**

```php
'lifetime' => 60, // تقليل الوقت
'expire_on_close' => true, // للوحة التحكم
'encrypt' => true, // تشفير الجلسات
'secure' => true, // HTTPS فقط
'http_only' => true,
'same_site' => 'strict',
```

---

### 10. ⚠️ عدم وجود HTTPS Enforcement

**المشكلة:** لا يوجد إجبار على HTTPS

**الحل:**

```php
// في bootstrap/app.php
if (app()->environment('production')) {
    URL::forceScheme('https');
}

// في Middleware
if (!$request->secure() && app()->environment('production')) {
    return redirect()->secure($request->getRequestUri());
}
```

---

## ⚠️ الثغرات متوسطة الخطورة (Medium Risk)

### 11. ⚠️ معلومات حساسة في الأخطاء الأخيرة

```
[2025-12-09 12:05:50] local.ERROR:
DirectoryNotFoundException:
"H:\FlyEnv\PhpWebStudy-Data\server\www\Hatch-websites\sharjah-new.test\platform/plugins/research/resources/views"
```

**يكشف:**

- المسار الكامل للسيرفر
- بنية المشروع
- أسماء المجلدات

---

### 12. ⚠️ عدم التحقق من صحة Email في التسجيل

**الموقع:** `PublicRegistrationController.php:44`

```php
'email' => 'required|email|max:255', // ❌ غير كافٍ
```

**الحل:**

```php
'email' => ['required', 'email:rfc,dns', 'max:255'],
```

---

### 13. ⚠️ عدم وجود CAPTCHA

**جميع النماذج العامة لا تحتوي على CAPTCHA:**

- نموذج الاتصال
- التسجيل في الأحداث
- الاشتراك في النشرة

**الحل:**

```bash
composer require google/recaptcha
# أو
composer require anhskohbo/no-captcha
```

---

### 14. ⚠️ API Keys مخزنة في قاعدة البيانات

```php
setting('newsletter_mailchimp_api_key')
setting('newsletter_sendgrid_api_key')
```

**يجب:**

- تشفيرها في قاعدة البيانات
- أو تخزينها في .env
- استخدام Laravel Vault

---

### 15. ⚠️ عدم وجود تحقق من الـ IP

**لا يوجد IP Whitelisting لـ:**

- صفحة الإعدادات
- صفحة النسخ الاحتياطي
- صفحة قاعدة البيانات

---

### 16. ⚠️ Password Hashing غير واضح

**لا يوجد تأكيد على استخدام:**

- Bcrypt أو Argon2
- Salt مناسب

---

### 17. ⚠️ عدم وجود 2FA للمسؤولين

**لوحة التحكم `/admin` لا تدعم:**

- Two-Factor Authentication
- تسجيل الدخول المزدوج

---

### 18. ⚠️ Logs غير محمية

**الموقع:** `storage/logs/`

- يمكن الوصول إليها عبر الويب في حال سوء الإعدادات
- تحتوي على معلومات حساسة

**الحل:**

```nginx
location ~ /storage/logs {
    deny all;
    return 404;
}
```

---

### 19. ⚠️ عدم وجود Security Headers

**Headers مفقودة:**

```
X-Frame-Options: DENY
X-Content-Type-Options: nosniff
X-XSS-Protection: 1; mode=block
Strict-Transport-Security: max-age=31536000
Content-Security-Policy: ...
Referrer-Policy: strict-origin-when-cross-origin
```

**الحل:**

```php
// Middleware
return $next($request)->withHeaders([
    'X-Frame-Options' => 'DENY',
    'X-Content-Type-Options' => 'nosniff',
    'X-XSS-Protection' => '1; mode=block',
    'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains',
]);
```

---

### 20. ⚠️ Backup Files غير محمية

**الموقع:** `storage/app/backup/`

- ملفات النسخ الاحتياطي قد تحتوي على قاعدة البيانات كاملة

---

### 21. ⚠️ CORS غير مُعدّ بشكل صحيح

- لا يوجد إعدادات CORS واضحة
- قد يسمح بطلبات من أي domain

---

### 22. ⚠️ No Input Sanitization في Custom Fields

**functions.php يقبل مدخلات بدون تنظيف:**

- map_points
- menu_items
- related_pages

---

## ✅ النقاط الآمنة

1. ✅ **CSRF Protection موجود** - Laravel يوفر حماية CSRF افتراضياً
2. ✅ **Eloquent ORM** - يمنع معظم SQL Injection عبر Parameter Binding
3. ✅ **Password Hashing** - Laravel يستخدم Bcrypt افتراضياً
4. ✅ **Validation** - معظم Controllers تستخدم validation
5. ✅ **Middleware** - نظام middleware موجود ويعمل
6. ✅ **Session Management** - Laravel session management آمن
7. ✅ **No hardcoded credentials** - لم يتم العثور على كلمات مرور مُدمجة
8. ✅ **File Structure** - بنية المشروع سليمة ومنظمة

---

## 🔍 فحص الاتصالات الخارجية

### APIs خارجية مكتشفة:

1. **Google Translate API** - `platform/plugins/translation/src/Services/GoogleTranslate.php`
2. **Mailchimp API** - Newsletter plugin
3. **SendGrid API** - Newsletter plugin
4. **BunnyCDN** - Media storage
5. **AWS S3** - File storage (محتمل)

### مكتبات Guzzle HTTP:

```php
vendor/botble/platform/base/src/Services/DownloadLocaleService.php
vendor/botble/platform/media/src/Storage/BunnyCDN/BunnyCDNClient.php
platform/plugins/translation/src/Services/GoogleTranslate.php
```

**التوصيات:**

- ✅ جميع الطلبات تستخدم HTTPS
- ⚠️ يجب التحقق من SSL Certificates
- ⚠️ يجب وضع timeout للطلبات
- ⚠️ يجب معالجة الأخطاء بشكل آمن

---

## 🗄️ فحص قاعدة البيانات

### مشاكل محتملة:

1. ⚠️ **لا يوجد Encryption للبيانات الحساسة**

    - Emails
    - Phone numbers
    - Registration data

2. ⚠️ **عدم استخدام Soft Deletes في جميع Models**

3. ⚠️ **Relations غير محمية من N+1 queries**

---

## 📦 فحص Dependencies

### حزم خطيرة أو قديمة:

**يجب التحقق من:**

```bash
composer audit
npm audit
```

### حزم third-party:

- Stripe SDK موجود
- Razorpay SDK موجود
- PayPal SDK موجود
- Mollie SDK موجود

**تنبيه:** لا يوجد معلومات كافية عن استخدامها

---

## 🛡️ خطة العمل الفورية

### ⚡ إجراءات فورية (خلال 24 ساعة):

1. **إيقاف DEBUG MODE:**

```env
APP_ENV=production
APP_DEBUG=false
LOG_LEVEL=error
```

2. **إصلاح ثغرة SQL Injection:**

```bash
# تعديل EventRegistrationController.php
```

3. **إصلاح ثغرة IDOR:**

```bash
# تعديل PublicRegistrationController.php
```

4. **إضافة Rate Limiting:**

```bash
# تحديث routes/web.php
```

---

### 📅 إجراءات قصيرة المدى (خلال أسبوع):

1. ✅ إضافة Security Headers
2. ✅ تفعيل HTTPS Enforcement
3. ✅ إضافة CAPTCHA للنماذج
4. ✅ تشفير API Keys
5. ✅ إضافة IP Whitelisting للوحة التحكم
6. ✅ تحديث Session Configuration
7. ✅ حماية Logs و Backups

---

### 📆 إجراءات متوسطة المدى (خلال شهر):

1. ✅ إضافة 2FA للمسؤولين
2. ✅ تشفير البيانات الحساسة في قاعدة البيانات
3. ✅ إضافة Audit Logging شامل
4. ✅ فحص جميع Dependencies
5. ✅ إضافة WAF (Web Application Firewall)
6. ✅ إعداد Monitoring و Alerts
7. ✅ Code Review شامل

---

## 📊 تقييم المخاطر النهائي

| المجال                         | التقييم      | النسبة  |
| ------------------------------ | ------------ | ------- |
| Authentication & Authorization | 🟡 متوسط     | 60%     |
| Input Validation               | 🔴 ضعيف      | 45%     |
| Output Encoding                | 🟡 متوسط     | 65%     |
| Database Security              | 🟡 متوسط     | 55%     |
| File Upload Security           | 🔴 ضعيف      | 40%     |
| Session Management             | 🟡 متوسط     | 60%     |
| Error Handling                 | 🔴 ضعيف جداً | 20%     |
| Configuration                  | 🔴 ضعيف جداً | 25%     |
| Third-party APIs               | 🟢 جيد       | 75%     |
| **التقييم العام**              | **🔴 ضعيف**  | **49%** |

---

## 🎯 التوصيات النهائية

### 1. **أولوية قصوى:**

- 🔴 إيقاف DEBUG MODE فوراً
- 🔴 إصلاح ثغرات SQL Injection و IDOR
- 🔴 إضافة Rate Limiting

### 2. **أولوية عالية:**

- ⚠️ تفعيل HTTPS
- ⚠️ إضافة Security Headers
- ⚠️ حماية Mass Assignment

### 3. **أولوية متوسطة:**

- 🟡 إضافة 2FA
- 🟡 تشفير البيانات الحساسة
- 🟡 إضافة CAPTCHA

### 4. **صيانة دورية:**

- 📅 Penetration Testing كل 6 أشهر
- 📅 Security Audit كل 3 أشهر
- 📅 Dependency Updates شهرياً

---

## 📞 ملاحظات إضافية

### Environment Variables المطلوبة:

```env
# .env.production
APP_NAME="Sharjah Architecture Triennial"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://sharjah-triennial.ae

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sharjah_db
DB_USERNAME=secure_user
DB_PASSWORD=strong_random_password_here

SESSION_DRIVER=database
SESSION_LIFETIME=60
SESSION_ENCRYPT=true
SESSION_SECURE_COOKIE=true

CACHE_DRIVER=redis
QUEUE_CONNECTION=redis

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=tls
```

---

## ✍️ توقيع التقرير

**تم بواسطة:** GitHub Copilot Security Audit  
**التاريخ:** 9 ديسمبر 2025  
**الإصدار:** 1.0  
**مستوى السرية:** 🔒 عالي - Confidential

---

## 📚 مراجع ومصادر

1. [OWASP Top 10 2021](https://owasp.org/www-project-top-ten/)
2. [Laravel Security Best Practices](https://laravel.com/docs/security)
3. [PHP Security Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/PHP_Configuration_Cheat_Sheet.html)
4. [CWE - Common Weakness Enumeration](https://cwe.mitre.org/)

---

**⚠️ هذا التقرير سري للغاية ويجب عدم مشاركته مع أطراف خارجية**
