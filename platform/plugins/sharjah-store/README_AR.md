# بلجن المتجر - Sharjah Store Plugin

تم إنشاء البلجن بنجاح! ✅

## المميزات

### المجموعات (Collections)
- إضافة / تعديل / حذف المجموعات
- رفع الصور
- دعم الترجمة (عربي وإنجليزي)
- ترتيب مخصص
- حالة النشر (منشور/مسودة)
- روابط SEO

### المنتجات (Products)
- إضافة / تعديل / حذف المنتجات
- محرر نصوص WYSIWYG مع دعم الـ Shortcodes
- رفع الصور
- دعم الترجمة (عربي وإنجليزي)
- ربط بالمجموعات
- ترتيب مخصص
- حالة النشر (منشور/مسودة)
- حقل **Content** (المحتوى الرئيسي)
- حقل **Down Row** (محتوى إضافي أسفل)

## الوصول للوحة التحكم

### المجموعات (Collections)
🔗 https://sharjah-new.test/admin/store/collections

### المنتجات (Products)
🔗 https://sharjah-new.test/admin/store/products

## الروابط الأمامية (Front-end)

- صفحة المجموعة: `/store/collections/{slug}`
- صفحة المنتج: `/store/products/{slug}`

## الأمثلة

### مثال لعرض المجموعات في الصفحة الأمامية

```blade
@if($collections = app(SharjahStore\Repositories\Interfaces\CollectionInterface::class)->getPublished(10))
    @foreach($collections as $collection)
        <div class="collection-item">
            <h3>{{ $collection->name }}</h3>
            <p>{{ $collection->description }}</p>
            <a href="{{ route('store.collection.single', $collection->slug) }}">عرض المجموعة</a>
        </div>
    @endforeach
@endif
```

### مثال لعرض المنتجات

```blade
@if($products = app(SharjahStore\Repositories\Interfaces\ProductInterface::class)->getPublished(10))
    @foreach($products as $product)
        <div class="product-item">
            <h3>{{ $product->name }}</h3>
            <p>{{ $product->description }}</p>
            @if($product->collection)
                <span>المجموعة: {{ $product->collection->name }}</span>
            @endif
            <a href="{{ route('store.product.single', $product->slug) }}">عرض المنتج</a>
        </div>
    @endforeach
@endif
```

### عرض المنتجات حسب المجموعة

```blade
@php
    $collectionId = 1; // معرف المجموعة
    $products = app(SharjahStore\Repositories\Interfaces\ProductInterface::class)->getByCollection($collectionId, 20);
@endphp

@foreach($products as $product)
    <div class="product">
        <h3>{{ $product->name }}</h3>
        {!! $product->content !!}
        {!! $product->down_row !!}
    </div>
@endforeach
```

## الجداول في قاعدة البيانات

### جدول المجموعات: `store_collections`
- المعلومات الأساسية: الاسم، الوصف، الصورة
- الترتيب والحالة
- دعم الترجمة في `store_collections_translations`

### جدول المنتجات: `store_products`
- المعلومات الأساسية: الاسم، الوصف، المحتوى، Down Row، الصورة
- ربط بالمجموعات عبر `collection_id`
- الترتيب والحالة
- دعم الترجمة في `store_products_translations`

## ملفات الثيم

تم إنشاء ملفات العرض في:
- `platform/themes/sharjah-triennial/layouts/collection-single.blade.php`
- `platform/themes/sharjah-triennial/layouts/product-single.blade.php`

## الصلاحيات (Permissions)

- `store.collections.index` - عرض قائمة المجموعات
- `store.collections.create` - إنشاء مجموعة جديدة
- `store.collections.edit` - تعديل المجموعات
- `store.collections.destroy` - حذف المجموعات
- `store.products.index` - عرض قائمة المنتجات
- `store.products.create` - إنشاء منتج جديد
- `store.products.edit` - تعديل المنتجات
- `store.products.destroy` - حذف المنتجات

## البيانات التجريبية

تم إنشاء:
- ✅ مجموعة تجريبية واحدة
- ✅ منتج تجريبي واحد

يمكنك الآن الدخول لوحة التحكم وإدارة المتجر!

## ملاحظات مهمة

1. البلجن يدعم الـ Shortcodes في حقول Content و Down Row
2. يمكن ترتيب المجموعات والمنتجات عن طريق حقل Order
3. كل المحتوى يدعم HTML الآمن (Safe HTML)
4. الترجمات تعمل تلقائياً مع نظام اللغات المتقدم في الموقع

## المطور

فريق Sharjah Architecture

## الإصدار

1.0.0
