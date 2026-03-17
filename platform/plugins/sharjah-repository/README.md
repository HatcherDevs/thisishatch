# Sharjah Repository Plugin

A Laravel plugin for managing repositories with categories, images, content editor, and UI blocks support.

## Features

### Repository Categories

- Name
- Status (Published/Draft)
- Translation support

### Repository Items

- Title (translatable)
- Category selection
- Image upload
- Content editor with UI blocks support
- Link field
- Status (Published/Draft)
- Translation support

## Installation

The plugin is already activated. To run migrations:

```bash
php artisan migrate
```

## Usage

Access the plugin from the admin panel:

- **Repositories** → Main menu item
    - **Repositories** → Manage repository items
    - **Categories** → Manage repository categories

## Permissions

The plugin includes the following permissions:

- Repository Categories: index, create, edit, destroy
- Repository Items: index, create, edit, destroy

## Translation

The plugin supports multilingual content through Laravel's language advanced module:

- English (en)
- Arabic (ar)

## Database Tables

- `repository_categories` - Stores categories
- `repository_categories_translations` - Stores category translations
- `repository_items` - Stores repository items
- `repository_items_translations` - Stores repository item translations
