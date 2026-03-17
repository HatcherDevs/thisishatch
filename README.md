# Sharjah Architecture Triennial 🏛️

[![Laravel](https://img.shields.io/badge/Laravel-12.19.3-FF2D20?style=flat-square&logo=laravel)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2.28-777BB4?style=flat-square&logo=php)](https://php.net)
[![Botble CMS](https://img.shields.io/badge/Botble-CMS-blue?style=flat-square)](https://botble.com)

**منصة ثقافية معمارية لملتقى الشارقة للعمارة الثلاثي** - A cultural platform celebrating architectural innovation and heritage.

---

## 📋 عن المشروع

ملتقى الشارقة للعمارة الثلاثي هو حدث ثقافي معماري يُقام كل ثلاث سنوات، يهدف إلى:
- 🏗️ عرض المشاريع المعمارية المبتكرة
- 🎨 تعزيز الحوار حول العمارة والتراث
- 🌍 ربط المعماريين والمفكرين من حول العالم
- 📚 تنظيم الفعاليات والورش التعليمية

---

## 🚀 التقنيات المستخدمة

### Backend
- **PHP** 8.2.28
- **Laravel** 12.19.3
- **Botble CMS** - نظام إدارة محتوى متكامل
- **MySQL** - قاعدة البيانات

### Frontend
- **Vue.js** 3.5.16
- **Bootstrap** 5.3.6
- **Laravel Mix** - بناء الأصول

### أدوات التطوير
- **Laravel Pint** - تنسيق الكود
- **PHPUnit** - الاختبارات
- **Laravel Sail** - بيئة Docker

---

## 📦 المميزات

### إدارة المحتوى
- ✅ إدارة المشاريع المعمارية
- ✅ نظام الفعاليات والمعارض
- ✅ إدارة المشاركين والمعماريين
- ✅ نظام المدونة والأخبار
- ✅ معرض الصور والوسائط

### التفاعل والمشاركة
- ✅ نظام التسجيل والحضور
- ✅ حجز التذاكر والورش
- ✅ التقييمات والتعليقات
- ✅ نظام البحث المتقدم
- ✅ المشاركة الاجتماعية

### أنظمة الدفع
- ✅ Stripe
- ✅ PayPal
- ✅ Razorpay
- ✅ Mollie
- ✅ Paystack

### اللغات والمواقع
- 🌐 دعم اللغات المتعددة (عربي/إنجليزي)
- 🌐 دعم RTL
- 📍 إدارة المواقع الجغرافية

---

## ⚙️ التثبيت والإعداد

### المتطلبات
- PHP >= 8.2
- Composer
- Node.js & npm
- MySQL >= 8.0

### خطوات التثبيت

1. **استنساخ المشروع**
```bash
git clone [repository-url]
cd sharjah-new.test
```

2. **تثبيت الحزم**
```bash
composer install
npm install
```

3. **إعداد البيئة**
```bash
cp .env.example .env
php artisan key:generate
```

4. **إعداد قاعدة البيانات**
```bash
# قم بتعديل معلومات قاعدة البيانات في .env
php artisan migrate
php artisan db:seed
```

5. **بناء الأصول**
```bash
npm run dev
# أو للإنتاج
npm run production
```

6. **إنشاء رابط التخزين**
```bash
php artisan storage:link
```

7. **تشغيل المشروع**
```bash
php artisan serve
```

---

## 🎨 الثيم المخصص

الثيم الحالي: **Sharjah Architecture Triennial** (`platform/themes/one-of-one/`)

### بنية الثيم
```
one-of-one/
├── assets/          # الأصول (CSS, JS, Images)
├── config.php       # إعدادات الثيم
├── functions/       # الدوال المساعدة
├── layouts/         # التخطيطات الأساسية
├── partials/        # الأجزاء القابلة للإعادة
├── views/           # صفحات العرض
└── theme.json       # معلومات الثيم
```

### تفعيل الثيم
```bash
php artisan cms:theme:activate one-of-one
```

---

## 📝 أوامر مفيدة

```bash
# تنسيق الكود
vendor/bin/pint

# مسح الـ cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# إنشاء مستخدم إداري
php artisan cms:user:create

# نشر الأصول
php artisan cms:publish:assets

# الاختبارات
php artisan test
```

---

## 📂 هيكل المشروع

```
sharjah-new.test/
├── app/                    # كود التطبيق
├── platform/               # Botble CMS
│   ├── core/              # نواة النظام
│   ├── packages/          # الحزم الأساسية
│   ├── plugins/           # البلجينز
│   │   ├── real-estate/   # وحدة المشاريع
│   │   ├── blog/          # المدونة
│   │   ├── location/      # المواقع
│   │   └── ...
│   └── themes/            # الثيمات
│       └── one-of-one/    # الثيم المخصص
├── public/                # الملفات العامة
├── resources/             # الموارد
└── storage/              # التخزين
```

---

## 🔌 البلجينز النشطة

- **real-estate** - إدارة المشاريع المعمارية
- **blog** - المدونة
- **location** - المواقع الجغرافية
- **language** - اللغات المتعددة
- **contact** - نماذج التواصل
- **newsletter** - القائمة البريدية
- **faq** - الأسئلة الشائعة
- **testimonial** - آراء الزوار
- **payment** - أنظمة الدفع
- **social-login** - تسجيل الدخول الاجتماعي

[المزيد من البلجينز متاحة في `platform/plugins/`]

---

## 🛠️ التطوير

### إضافة ميزات جديدة

1. استخدم أوامر Artisan لإنشاء الملفات
```bash
php artisan make:model ModelName -mcr
php artisan cms:make:controller ControllerName
```

2. اتبع معايير Laravel و Botble CMS
3. قم بتشغيل Pint لتنسيق الكود قبل الـ commit
```bash
vendor/bin/pint
```

### الاختبار
```bash
# تشغيل جميع الاختبارات
php artisan test

# تشغيل اختبار معين
php artisan test --filter=TestName
```

---

## 📄 الترخيص

هذا المشروع مرخص تحت [MIT License](LICENSE).

---

## 👥 الفريق

- **Sharjah Architecture Triennial Team**
- Built with ❤️ using Botble CMS

---

## 📞 التواصل

- 🌐 الموقع: [https://sharjah-new.test](https://sharjah-new.test)
- 📧 البريد الإلكتروني: [contact@example.com]
- 📱 لوحة التحكم: [https://sharjah-new.test/admin](https://sharjah-new.test/admin)

---

## 📚 موارد إضافية

- [Laravel Documentation](https://laravel.com/docs)
- [Botble CMS Documentation](https://docs.botble.com)
- [Vue.js Documentation](https://vuejs.org)

---

**آخر تحديث**: 29 أكتوبر 2025
