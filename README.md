# lalalili/campaign-kit-filament

Optional Filament integration package for `lalalili/campaign-kit`.

This package provides a reusable Filament preview view for campaign type selection UI.

## Scope

In package scope:

- Filament preview Blade view namespace registration
- Publishable Filament preview view

Out of package scope:

- Campaign core routing and rendering (handled by `lalalili/campaign-kit`)
- Host app campaign domain logic and adapter binding

## Requirements

- PHP `^8.4`
- Laravel `^12.0`
- Filament `^4.0` (`forms` + `schemas`)
- `lalalili/campaign-kit` `^0.1`

## Install

### Option A: Local path repository

In app `composer.json`:

```json
{
  "repositories": [
    {
      "type": "path",
      "url": "packages/campaign-kit-filament",
      "options": {
        "symlink": true
      }
    }
  ],
  "require": {
    "lalalili/campaign-kit-filament": "^0.1"
  }
}
```

Then run:

```bash
composer update lalalili/campaign-kit-filament
```

### Option B: Private VCS repository

In app `composer.json`:

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "git@github.com:lalalili/campaign-kit-filament.git"
    }
  ],
  "require": {
    "lalalili/campaign-kit-filament": "^0.1"
  }
}
```

Then run:

```bash
composer update lalalili/campaign-kit-filament
```

## Usage

Use package view directly in Filament form schema:

```php
use Filament\Schemas\Components\View;

View::make('campaign-kit-filament::filament.forms.campaign-type-preview')
    ->reactive()
    ->columnSpanFull();
```

The preview view depends on:

- `route('campaign.layout-preview')`
- `config('campaign-kit.preview.types')`

## Publish

If you want to customize the preview Blade in host app:

```bash
php artisan vendor:publish --tag=campaign-kit-filament-views
```

Published target:

- `resources/views/filament/forms/campaign-type-preview.blade.php`

## Local Quality Checks

Inside package directory:

```bash
composer install
composer test
composer analyse
```

