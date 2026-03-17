# Sharjah Store Plugin

A comprehensive plugin for managing store collections and products for the Sharjah Architecture Triennial website.

## Features

### Collections (المجموعات)
- Complete CRUD interface for collections
- Image upload support
- Multi-language support (Arabic & English)
- Custom ordering
- Status management (Published/Draft)
- SEO-friendly slugs

### Products (المنتجات)
- Complete CRUD interface for products
- Rich text editor with shortcode support
- Image upload support
- Multi-language support (Arabic & English)
- Collection assignment
- Custom ordering
- Status management (Published/Draft)
- SEO-friendly slugs
- **Content** field with WYSIWYG editor and shortcode UI
- **Down Row** field with WYSIWYG editor and shortcode UI

## Installation

1. The plugin is located in `platform/plugins/sharjah-store`
2. Run composer autoload:
   ```bash
   composer dump-autoload
   ```
3. Run migrations to create the store tables:
   ```bash
   php artisan migrate
   ```
4. Clear cache:
   ```bash
   php artisan cache:clear
   php artisan config:clear
   ```

## Usage

### Admin Panel

- Access the Store management from the admin dashboard sidebar
- **Collections**: Create, edit, and delete collections
- **Products**: Create, edit, and delete products
- Assign products to collections
- Upload images for collections and products
- Use the WYSIWYG editor with shortcode support for product content

### Programmatic Usage

```php
use SharjahStore\Repositories\Interfaces\CollectionInterface;
use SharjahStore\Repositories\Interfaces\ProductInterface;

// Get all published collections
$collections = app(CollectionInterface::class)->getPublished(10);

// Get all published products
$products = app(ProductInterface::class)->getPublished(10);

// Get products by collection
$products = app(ProductInterface::class)->getByCollection($collectionId, 10);
```

### Front-end URLs

- Collection page: `/store/collections/{slug}`
- Product page: `/store/products/{slug}`

### Blade Templates

```blade
{{-- Display all collections --}}
@if($collections = app(SharjahStore\Repositories\Interfaces\CollectionInterface::class)->getPublished())
    @foreach($collections as $collection)
        <div class="collection">
            <h3>{{ $collection->name }}</h3>
            <p>{{ $collection->description }}</p>
            <a href="{{ route('store.collection.single', $collection->slug) }}">View Collection</a>
        </div>
    @endforeach
@endif

{{-- Display all products --}}
@if($products = app(SharjahStore\Repositories\Interfaces\ProductInterface::class)->getPublished())
    @foreach($products as $product)
        <div class="product">
            <h3>{{ $product->name }}</h3>
            <p>{{ $product->description }}</p>
            <a href="{{ route('store.product.single', $product->slug) }}">View Product</a>
        </div>
    @endforeach
@endif
```

## Database Schema

### Collections Table (`store_collections`)
- `id` - Primary key
- `name` - Collection name
- `slug` - SEO-friendly URL slug
- `description` - Collection description
- `image` - Collection image path
- `status` - Publication status
- `order` - Display order
- `created_at`, `updated_at` - Timestamps

### Products Table (`store_products`)
- `id` - Primary key
- `name` - Product name
- `slug` - SEO-friendly URL slug
- `description` - Short description
- `content` - Full content (WYSIWYG)
- `down_row` - Additional content section (WYSIWYG)
- `image` - Product image path
- `collection_id` - Foreign key to collections
- `status` - Publication status
- `order` - Display order
- `created_at`, `updated_at` - Timestamps

## Multi-language Support

The plugin supports translations for:
- Collection names and descriptions
- Product names, descriptions, content, and down_row

Translation files:
- `resources/lang/en/collections.php`
- `resources/lang/ar/collections.php`
- `resources/lang/en/products.php`
- `resources/lang/ar/products.php`

## Permissions

The plugin includes the following permissions:
- `store.collections.index` - View collections list
- `store.collections.create` - Create new collections
- `store.collections.edit` - Edit collections
- `store.collections.destroy` - Delete collections
- `store.products.index` - View products list
- `store.products.create` - Create new products
- `store.products.edit` - Edit products
- `store.products.destroy` - Delete products

## Front-end Views

Theme views are located in:
- `platform/themes/sharjah-triennial/layouts/collection-single.blade.php`
- `platform/themes/sharjah-triennial/layouts/product-single.blade.php`

## Author

Sharjah Architecture Team

## Version

1.0.0
