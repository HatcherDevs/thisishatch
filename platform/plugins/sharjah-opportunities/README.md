# Sharjah Opportunities Plugin

A simple plugin for managing job opportunities and career vacancies in the Sharjah Architecture Triennial website.

## Features

- Complete CRUD interface for opportunities
- Multi-language support (Arabic & English)
- Image upload support
- Rich text editor with UI blocks
- SEO-friendly permalinks
- Status management (Draft, Published)
- Admin dashboard integration

## Installation

1. The plugin is located in `platform/plugins/sharjah-opportunities`
2. Run composer update to register the plugin:
   ```bash
   composer update
   ```

3. Run migrations to create the opportunities table:
   ```bash
   php artisan migrate
   ```

## Usage

### Admin Panel
- Access the opportunities management from the admin dashboard
- Create, edit, and delete opportunities
- Manage opportunity images, descriptions, and content
- Set permalinks and status

### Frontend Integration
Use the repository in your theme or views:

```php
use SharjahOpportunities\Repositories\Interfaces\OpportunityInterface;

// Get all published opportunities
$opportunities = app(OpportunityInterface::class)->getPublished(10);

// Get opportunity by permalink
$opportunity = app(OpportunityInterface::class)->getByPermalink('web-developer');

// Get featured opportunities
$featured = app(OpportunityInterface::class)->getFeatured(5);
```

### Blade Examples

```blade
{{-- Display all opportunities --}}
@if($opportunities = app(SharjahOpportunities\Repositories\Interfaces\OpportunityInterface::class)->getPublished())
    @foreach($opportunities as $opportunity)
        <div class="opportunity-item">
            <h3>{{ $opportunity->name }}</h3>
            @if($opportunity->image)
                <img src="{{ RvMedia::getImageUrl($opportunity->image) }}" alt="{{ $opportunity->name }}">
            @endif
            <p>{{ $opportunity->description }}</p>
            <a href="/opportunities/{{ $opportunity->permalink }}">Read More</a>
        </div>
    @endforeach
@endif
```

## Database Structure

The plugin creates an `opportunities` table with:
- `id` - Primary key
- `name` - Opportunity title
- `image` - Featured image path
- `permalink` - SEO-friendly URL slug
- `description` - Short description (max 400 chars)
- `content` - Full content with rich text
- `status` - Publication status
- `created_at` / `updated_at` - Timestamps

## Language Support

The plugin supports multiple languages and integrates with Botble's language advanced features. Translation files are available in:
- `resources/lang/en/opportunities.php`
- `resources/lang/ar/opportunities.php`

## Permissions

The plugin registers the following permissions:
- `opportunities.index` - View opportunities list
- `opportunities.create` - Create new opportunities
- `opportunities.edit` - Edit existing opportunities  
- `opportunities.destroy` - Delete opportunities