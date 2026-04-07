# Local Plugins (Drop‑in) – Developer Guide

This document explains how to build, register, and operate local “drop‑in” plugins that live under the project `Plugins/` directory. It targets third‑party developers who want to add custom functionality without going through the external Lara Script marketplace.

## Overview

- Location: one folder per plugin under `Plugins/`.
- Manifest: each plugin has a `manifest.php` describing metadata and the provider class to load.
- Autoload: Composer already maps `Plugins\` → `Plugins/`, so classes under `Plugins/<YourPlugin>` are autoloaded if you use the `Plugins\<YourPlugin>\...` namespace.
- Activation: only plugins registered in the database and marked ACTIVE are bootstrapped; the system registers their provider classes at app boot.
- IDs: local plugins use negative `external_id` values to avoid collisions with external (Lara Script) plugins.

## Directory Layout

```
Plugins/
  YourPlugin/
    manifest.php
    Providers/
      YourPluginServiceProvider.php
    database/
      migrations/           # optional (recommended for schema changes)
    routes/                 # optional
    resources/              # optional (views, lang, etc.)
    index.php               # optional bootstrap file (see notes below)
```

## Manifest (manifest.php)

The manifest is a plain PHP file returning an associative array. Minimum required keys:

- `version` (string): semantic version of your plugin.
- `title` (string): human‑readable name.
- `description` (string): short description.
- `author` (string): your name or organization.
- `provider_path` (string): FQCN of your service provider (must be autoloadable).

Optional keys:

- `migration_path` (string): relative path to migrations (default: `database/migrations`).
- `categories` (string[]): classification tags.
- `scopes` (string[]): custom capability hints.
- `settings_schema` (string): path to a JSON schema used for plugin settings (if you implement settings via the framework contracts).

Example:

```php
<?php
declare(strict_types=1);

return [
    'version' => '1.0.0',
    'title' => 'Awesome Widget',
    'description' => 'Adds widgets to the dashboard.',
    'author' => 'Acme Inc.',
    'provider_path' => 'Plugins\\AwesomeWidget\\Providers\\AwesomeWidgetServiceProvider',
    'migration_path' => 'database/migrations',
    'categories' => ['ui'],
    'scopes' => ['widgets:read'],
];
```

## Service Provider

Your provider should extend `Illuminate\Support\ServiceProvider`. The system registers providers for all ACTIVE plugins on boot.

Minimal example:

```php
<?php
declare(strict_types=1);

namespace Plugins\AwesomeWidget\Providers;

use Illuminate\Support\ServiceProvider;

final class AwesomeWidgetServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Bind services, singletons, interfaces → implementations.
    }

    public function boot(): void
    {
        // Load routes, views, config, migrations as needed.
        // Example helpers:
        // $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        // $this->loadViewsFrom(__DIR__ . '/../resources/views', 'awesome');
        // $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}
```

Advanced integrations (optional): If your plugin wants to expose settings, merchant providers, or other components through the host, implement the contracts from `lara-script-dev/lara-plugin-framework` and return an `implementations()` map from a provider that implements `LaraPluginFramework\Contracts\PluginServiceProviderInterface` (see the `BcParser` example in this repo).

## Autoloading and Dependencies

- Use the `Plugins\<YourPlugin>\...` namespace for your PHP classes; files live under `Plugins/<YourPlugin>/...`.
- Avoid bundling a separate Composer autoloader inside your plugin. The host app already autoloads `Plugins\`.
- Optional `index.php`: if present, it may be executed on activation to bootstrap lightweight dependencies. If your plugin ships a `vendor/autoload.php`, the host will skip executing `index.php` to avoid conflicts.

## Lifecycle and Statuses

Plugin statuses:

- `INSTALLED`: registered in the database but not active.
- `ACTIVE`: provider is registered on boot; migrations are executed if configured.
- `DISABLED`: installed but inactive.
- `UNINSTALLED`: removed (soft‑deleted record).

For local plugins (`is_local = true`), no calls are made to the external Lara Script API during status changes.

## Artisan Commands

Core commands for local plugins:

- Register a single plugin by folder (creates/updates DB row):
  - `php artisan plugins:register {folder} [--enable] [--force]`
  - `--enable` sets status to ACTIVE and runs migrations.
  - `--force` generates a minimal `manifest.php` if it’s missing (you still need to provide the provider class).

- Activate an installed plugin by ID (works for local negative IDs too):
  - `php artisan plugins:activate {plugin_id}`

Removal:

- Remove a plugin by ID or by folder name:
  - `php artisan plugins:remove --id=-123` (negative local IDs) or `php artisan plugins:remove 1001` (external positive IDs)
  - `php artisan plugins:remove --folder=YourPlugin`
  - Tip: for positional negative IDs, add `--` before the argument (e.g., `php artisan plugins:remove -- -123`).
  - If a DB record exists, the system removes the plugin via lifecycle (deletes folder, marks record uninstalled). If there is no record, the command deletes the folder only.

## Quick Start

1) Create folder and provider

```
mkdir -p Plugins/AwesomeWidget/Providers
```

Create `Plugins/AwesomeWidget/Providers/AwesomeWidgetServiceProvider.php` using the sample above.

2) Add manifest

Create `Plugins/AwesomeWidget/manifest.php` with your metadata and the `provider_path`.

3) Register the plugin

```
php artisan plugins:register AwesomeWidget --enable
```

4) Verify in Admin/API

Use the admin API to list plugins (local and external appear together):

```
GET /admin/v1/plugins
Authorization: (admin)
```

5) Iterate

- Add routes/views/migrations under your plugin folder and expose them from the provider.
- Re‑run `php artisan migrate` if you add migrations.

## Migrations

If `migration_path` is set in `manifest.php` (default `database/migrations`), migrations are executed on activation via `php artisan migrate --path=Plugins/<YourPlugin>/<migration_path> --force`.

## Settings (Optional)

To expose plugin settings to the host application:

1) Implement the settings contracts from `lara-script-dev/lara-plugin-framework` (e.g., `SettingsGetterInterface`, `SettingsValueGetterInterface`, `SettingsSaverInterface`).
2) In your provider (implementing `PluginServiceProviderInterface`), return these implementations from `implementations()`.
3) Optionally provide a JSON schema at `settings_schema` in the manifest; the host will load and render it in the admin UI.

## Troubleshooting

- Provider class not found: ensure your `provider_path` matches the namespace and path under `Plugins/` and the file is loaded by Composer (namespace starts with `Plugins\\`).
- Not showing in the list: plugins appear only after registration (via `plugins:register`).
- Activation issues: inspect logs; ensure migrations path exists and contains valid Laravel migration files.
- Local vs external: local plugins have negative IDs (`external_id < 0`). External plugins keep their positive marketplace IDs.

## Security Notes

- Only files under `Plugins/` are considered for local plugins. The system validates provider classes and ignores invalid entries without crashing the app.
- A faulty plugin is skipped with an error logged; other plugins continue to load.
