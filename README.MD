# Plugin Development Guide

This guide provides comprehensive documentation for developing plugins for the Lara Exchange platform.

---

## Table of Contents

- [Introduction](#introduction)
- [Getting Started](#getting-started)
  - [Requirements](#requirements)
  - [Plugin Structure](#plugin-structure)
  - [Mandatory Plugin Structure](#mandatory-plugin-structure)
  - [Quick Start](#quick-start)
- [Architecture](#architecture)
  - [Plugin Lifecycle](#plugin-lifecycle)
  - [Service Provider](#service-provider)
  - [Dependency Injection](#dependency-injection)
- [Settings System](#settings-system)
  - [Defining Settings Schema](#defining-settings-schema)
  - [Saving Settings](#saving-settings)
  - [Retrieving Settings](#retrieving-settings)
- [Events & Hooks](#events--hooks)
  - [Available Events](#available-events)
  - [Listening to Events](#listening-to-events)
  - [Event Reference](#event-reference)
- [Merchant Integration](#merchant-integration)
  - [Creating a Merchant](#creating-a-merchant)
  - [Registering a Merchant](#registering-a-merchant)
  - [Handling Notifications](#handling-notifications)
  - [Merchant Settings](#merchant-settings)
- [Rate Providers](#rate-providers)
  - [Creating a Rate Provider](#creating-a-rate-provider)
  - [Registering Rate Providers](#registering-rate-providers)
- [Order Service](#order-service)
  - [Reading Orders](#reading-orders)
  - [Modifying Orders](#modifying-orders)
- [Entities Reference](#entities-reference)
- [Best Practices](#best-practices)
- [Examples](#examples)

---

## Introduction

The Lara Exchange plugin system allows third-party developers to extend the platform's functionality. Plugins can:

- Add new payment processors (merchants)
- Provide custom exchange rate sources
- React to system events (orders, currencies, verifications)
- Add custom settings manageable via admin panel
- Integrate with external services

All plugins must implement the `LaraPluginFramework` contracts, which provide a standardized interface for communication between the core platform and plugins.

Quick link: see the Required Minimal Plugin Layout at [Mandatory Plugin Structure](#mandatory-plugin-structure).

---

## Getting Started

### Requirements

| Requirement | Version |
|-------------|---------|
| PHP | 8.1+ |
| Composer | 2.x |
| lara-plugin-framework | ^1.0 |

### Plugin Structure

A typical plugin follows this directory structure:

```
my-plugin/
├── src/
│   ├── MyPluginServiceProvider.php
│   ├── Settings/
│   │   ├── SettingsGetter.php
│   │   ├── SettingsSaver.php
│   │   └── SettingsValueGetter.php
│   ├── Merchant/
│   │   ├── MyMerchant.php
│   │   └── MyMerchantSettings.php
│   ├── Listeners/
│   │   └── OrderStatusListener.php
│   └── Rates/
│       └── MyRateProvider.php
├── database/
│   └── migrations/
│       └── 2024_01_01_000000_create_my_plugin_tables.php
├── config/
│   └── my-plugin.php
├── manifest.php
├── index.php
└── composer.json
```

### Mandatory Plugin Structure

NOTE: For the loader to work correctly, the plugin must include at least the following files and paths:

```
my-plugin/
├── config/
│   └── schema.json   # required: JSON schema for the settings form
├── manifest.php      # required: plugin manifest
└── src/
    └── Providers/
        └── MyPluginServiceProvider.php  # service provider class
```

Minimal `manifest.php` example (keys expected by the loader):

```php
<?php

return [
    // Version and basic metadata
    'version' => '1.0.0',
    'title' => 'My Plugin',
    'description' => 'Short description',
    'author' => 'Your Name',

    // Required: fully-qualified service provider class path
    'provider_path' => 'MyPlugin\\Providers\\MyPluginServiceProvider',

    // Required: path to the settings JSON schema relative to plugin root
    'settings_schema' => 'config/schema.json',

    // Optional but recommended (if you ship migrations)
    'migration_path' => 'database/migrations',

    // Optional extras (as needed)
    'categories' => ['example'],
    'scopes' => ['example:scope'],
];
```

Minimal `config/schema.json` example (settings form structure):

```json
{
  "settings": [
    {
      "type": "tab",
      "name": "General",
      "id": "general",
      "fields": {
        "example_field": {
          "type": "text",
          "label": "Example field",
          "required": false
        }
      }
    }
  ]
}
```

Note: All plugins are stored in the backend project's root `Plugins/` directory (e.g., `<backend-root>/Plugins/my-plugin`).

### Quick Start

**1. Create the manifest file**

```php
<?php
// manifest.php

return [
    'migration_path' => 'database/migrations',
];
```

**2. Create the entry point**

```php
<?php
// index.php

require_once __DIR__ . '/vendor/autoload.php';
```

**3. Create the Service Provider**

```php
<?php
// src/MyPluginServiceProvider.php

namespace MyPlugin;

use LaraPluginFramework\Contracts\PluginServiceProviderInterface;
use LaraPluginFramework\Contracts\SettingsGetterInterface;
use LaraPluginFramework\Contracts\SettingsSaverInterface;
use LaraPluginFramework\Contracts\SettingsValueGetterInterface;

class MyPluginServiceProvider implements PluginServiceProviderInterface
{
    public function implementations(): array
    {
        return [
            SettingsGetterInterface::class => \MyPlugin\Settings\SettingsGetter::class,
            SettingsSaverInterface::class => \MyPlugin\Settings\SettingsSaver::class,
            SettingsValueGetterInterface::class => \MyPlugin\Settings\SettingsValueGetter::class,
        ];
    }
}
```

**4. Configure composer.json**

```json
{
    "name": "vendor/my-plugin",
    "description": "My custom plugin for Lara Exchange",
    "type": "lara-plugin",
    "require": {
        "php": "^8.1",
        "cakealliance/lara-plugin-framework": "^1.0"
    },
    "autoload": {
        "psr-4": {
            "MyPlugin\\": "src/"
        }
    }
}
```

---

## Architecture

### Plugin Lifecycle

Plugins go through the following states:

| Status | Value | Description |
|--------|-------|-------------|
| `INSTALLED` | 3 | Plugin files extracted, not yet activated |
| `ACTIVE` | 1 | Plugin is running and processing events |
| `DISABLED` | 2 | Plugin is installed but deactivated |
| `UNINSTALLED` | 4 | Plugin has been removed |

**Lifecycle Flow:**

```
┌─────────────┐     ┌──────────┐     ┌────────┐
│  INSTALLED  │ ──► │  ACTIVE  │ ◄─► │DISABLED│
└─────────────┘     └──────────┘     └────────┘
                          │
                          ▼
                   ┌─────────────┐
                   │ UNINSTALLED │
                   └─────────────┘
```

**Installation Process:**

1. Plugin metadata fetched from LaraScript
2. Plugin archive (ZIP) downloaded
3. Files extracted to `/Plugins` directory
4. Database record created with `INSTALLED` status

**Activation Process:**

1. Entry point (`index.php`) bootstrapped
2. Migrations executed from manifest path
3. Service provider registered in container
4. Status set to `ACTIVE`
5. Events start being dispatched to plugin

### Service Provider

The `PluginServiceProviderInterface` is the main entry point for your plugin:

```php
interface PluginServiceProviderInterface
{
    /**
     * @return array<class-string, class-string>
     */
    public function implementations(): array;
}
```

The `implementations()` method returns a map of contract interfaces to concrete implementation classes:

```php
public function implementations(): array
{
    return [
        // Settings
        SettingsGetterInterface::class => SettingsGetter::class,
        SettingsSaverInterface::class => SettingsSaver::class,
        SettingsValueGetterInterface::class => SettingsValueGetter::class,

        // Merchant (optional)
        MerchantSettingsInterface::class => MyMerchantSettings::class,

        // Rate provider (optional)
        RateProviderInterface::class => MyRateProvider::class,
    ];
}
```

### Dependency Injection

The platform uses Laravel's service container. Your implementations receive dependencies via constructor injection:

```php
class SettingsGetter implements SettingsGetterInterface
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository,
        private readonly AdminUserGetterInterface $adminUserGetter,
    ) {}

    public function get(): string
    {
        // Access injected dependencies
        $adminUser = $this->adminUserGetter->getAdminUser();
        // ...
    }
}
```

**Available Injectable Contracts:**

| Contract | Description |
|----------|-------------|
| `OrderRepositoryInterface` | Read orders by ID or hash |
| `OrderServiceInterface` | Modify order status and amounts |
| `AdminUserGetterInterface` | Get current admin user |
| `FeatureFlagRepositoryInterface` | Check feature flags |
| `CompositeRateProviderInterface` | Add rate providers |
| `MerchantRegistryInterface` | Register merchants |
| `CheckStatusCompositeInterface` | Register status checkers |

---

## Settings System

The settings system allows plugins to define configurable options that administrators can manage through the admin panel.

### Defining Settings Schema

Implement `SettingsGetterInterface` to define your settings schema:

```php
<?php

namespace MyPlugin\Settings;

use LaraPluginFramework\Contracts\SettingsGetterInterface;
use LaraPluginFramework\Fields\FieldBuilder;

class SettingsGetter implements SettingsGetterInterface
{
    public function get(): string
    {
        $fields = [
            'api_key' => (new FieldBuilder())
                ->password('api_key')
                ->label('API Key')
                ->required()
                ->helperText('Your API key from the provider dashboard')
                ->build(),

            'api_secret' => (new FieldBuilder())
                ->password('api_secret')
                ->label('API Secret')
                ->required()
                ->build(),

            'environment' => (new FieldBuilder())
                ->select('environment')
                ->label('Environment')
                ->required()
                ->options([
                    ['value' => 'sandbox', 'label' => 'Sandbox'],
                    ['value' => 'production', 'label' => 'Production'],
                ])
                ->default('sandbox')
                ->build(),

            'notification_email' => (new FieldBuilder())
                ->email('notification_email')
                ->label('Notification Email')
                ->optional()
                ->placeholder('admin@example.com')
                ->build(),

            'sync_time' => (new FieldBuilder())
                ->time('sync_time')
                ->label('Daily Sync Time')
                ->optional()
                ->helperText('When to sync data daily')
                ->build(),
        ];

        return json_encode(
            array_map(fn($field) => $field->toArray(), $fields)
        );
    }
}
```

**Available Field Types:**

| Type | Method | Description |
|------|--------|-------------|
| Text | `->text($name)` | Single-line text input |
| Password | `->password($name)` | Masked password input |
| Email | `->email($name)` | Email input with validation |
| Select | `->select($name)` | Dropdown selection |
| Time | `->time($name)` | Time picker |

**Field Builder Methods:**

| Method | Description |
|--------|-------------|
| `->label(string)` | Display label |
| `->required()` | Mark as required |
| `->optional()` | Mark as optional |
| `->placeholder(string)` | Placeholder text |
| `->helperText(string)` | Help text below field |
| `->options(array)` | Options for select fields |
| `->multiple()` | Allow multiple selection |
| `->default(mixed)` | Default value |

### Saving Settings

Implement `SettingsSaverInterface` to handle settings persistence:

```php
<?php

namespace MyPlugin\Settings;

use LaraPluginFramework\Contracts\SettingsSaverInterface;
use Illuminate\Support\Facades\DB;

class SettingsSaver implements SettingsSaverInterface
{
    /**
     * @param array<string, mixed> $settings
     * @return array<string, mixed>
     */
    public function save(array $settings): array
    {
        // Validate required fields
        if (empty($settings['api_key'])) {
            return [
                'success' => false,
                'error' => 'API Key is required',
            ];
        }

        // Save to database
        DB::table('my_plugin_settings')->updateOrInsert(
            ['key' => 'main'],
            [
                'api_key' => encrypt($settings['api_key']),
                'api_secret' => encrypt($settings['api_secret']),
                'environment' => $settings['environment'] ?? 'sandbox',
                'notification_email' => $settings['notification_email'] ?? null,
                'sync_time' => $settings['sync_time'] ?? null,
                'updated_at' => now(),
            ]
        );

        return [
            'success' => true,
            'message' => 'Settings saved successfully',
        ];
    }
}
```

### Retrieving Settings

Implement `SettingsValueGetterInterface` to return current values:

```php
<?php

namespace MyPlugin\Settings;

use LaraPluginFramework\Contracts\SettingsValueGetterInterface;
use Illuminate\Support\Facades\DB;

class SettingsValueGetter implements SettingsValueGetterInterface
{
    /**
     * @return array<string, mixed>
     */
    public function get(): array
    {
        $settings = DB::table('my_plugin_settings')
            ->where('key', 'main')
            ->first();

        if (!$settings) {
            return [];
        }

        return [
            'api_key' => $settings->api_key ? decrypt($settings->api_key) : '',
            'api_secret' => $settings->api_secret ? decrypt($settings->api_secret) : '',
            'environment' => $settings->environment ?? 'sandbox',
            'notification_email' => $settings->notification_email ?? '',
            'sync_time' => $settings->sync_time ?? '',
        ];
    }
}
```

---

## Events & Hooks

The platform dispatches events for major domain actions. Plugins can listen to these events to react to system changes.

### Available Events

#### Order Events

| Event | Interface | Description |
|-------|-----------|-------------|
| Status Changed | `OrderChangeStatusEventInterface` | Order status transitioned |
| Amount Changed | `OrderAmountChangedEventInterface` | In/Out/Paid amount modified |
| Recalculated | `OrderRecalculatedEventInterface` | Order rate recalculated |
| Commented | `OrderCommentedEventInterface` | Admin comment added |
| Assigned | `OrderAssignedEventInterface` | Admin assigned to order |
| Unassigned | `OrderUnassignedEventInterface` | Admin unassigned |
| Receipt Added | `OrderRecipientAddedEventInterface` | Receipt uploaded |
| Receipt Deleted | `OrderReceiptDeletedEventInterface` | Receipt removed |
| Requisite Changed | `OrderRequisiteChangedEventInterface` | Wallet address changed |
| Deleted | `OrderDeletedEventInterface` | Order deleted |

#### Currency Events

| Event | Interface | Description |
|-------|-----------|-------------|
| Created | `CurrencyCreatedEventInterface` | New currency added |
| Updated | `CurrencyUpdatedEventInterface` | Currency modified |
| Deleted | `CurrencyDeletedEventInterface` | Currency removed |

#### Direction Events

| Event | Interface | Description |
|-------|-----------|-------------|
| Created | `DirectionCreatedEventInterface` | New direction created |
| Updated | `DirectionUpdatedEventInterface` | Direction modified |
| Deleted | `DirectionDeletedEventInterface` | Direction removed |

#### Quote Events

| Event | Interface | Description |
|-------|-----------|-------------|
| Created | `QuoteCreatedEventInterface` | New quote created |
| Updated | `QuoteUpdatedEventInterface` | Quote modified |
| Deleted | `QuoteDeletedEventInterface` | Quote removed |

#### Admin User Events

| Event | Interface | Description |
|-------|-----------|-------------|
| Created | `AdminUserCreatedEvent` | Admin user created |
| Deleted | `AdminUserDeletedEvent` | Admin user deleted |

#### Verification Events

| Event | Interface | Description |
|-------|-----------|-------------|
| User Verification | `UserVerificationUpdatedEventInterface` | KYC status changed |
| Requisite Verification | `RequisiteVerificationUpdatedEventInterface` | Wallet verification changed |

#### Financial Events

| Event | Interface | Description |
|-------|-----------|-------------|
| Withdraw Updated | `WithdrawUpdatedEventInterface` | Withdrawal status changed |
| Virtual Balance Changed | `VirtualBalanceChangedEventInterface` | Balance adjustment |

### Listening to Events

Register event listeners in Laravel's `EventServiceProvider` or use the `Event` facade:

```php
<?php

namespace MyPlugin\Listeners;

use LaraPluginFramework\Contracts\Events\OrderChangeStatusEventInterface;
use LaraPluginFramework\Enums\OrderStatusEnum;

class OrderStatusListener
{
    public function handle(OrderChangeStatusEventInterface $event): void
    {
        $order = $event->order();
        $oldStatus = $event->oldStatus();
        $newStatus = $event->newStatus();
        $author = $event->author();

        // React to status change
        if ($newStatus === OrderStatusEnum::COMPLETED_STATUS) {
            $this->sendCompletionNotification($order);
        }

        // Log the change
        logger()->info('Order status changed', [
            'order_id' => $order->getId(),
            'from' => $oldStatus?->value,
            'to' => $newStatus->value,
            'by' => $author?->getName(),
        ]);
    }

    private function sendCompletionNotification($order): void
    {
        // Send notification logic
    }
}
```

**Register in your plugin's service provider:**

```php
// In your plugin initialization
use Illuminate\Support\Facades\Event;
use LaraPluginFramework\Contracts\Events\OrderChangeStatusEventInterface;

Event::listen(
    OrderChangeStatusEventInterface::class,
    \MyPlugin\Listeners\OrderStatusListener::class
);
```

### Event Reference

#### OrderChangeStatusEventInterface

```php
interface OrderChangeStatusEventInterface
{
    public function oldStatus(): ?OrderStatusEnum;
    public function newStatus(): OrderStatusEnum;
    public function order(): Order;
    public function author(): ?AdminUser;
}
```

#### OrderAmountChangedEventInterface

```php
interface OrderAmountChangedEventInterface
{
    public function order(): Order;
    public function type(): OrderAmountTypeEnum;  // IN, OUT, or PAID
    public function oldAmount(): Decimal;
    public function newAmount(): Decimal;
    public function author(): ?AdminUser;
}
```

**Order Amount Types:**

| Type | Value | Description |
|------|-------|-------------|
| `IN` | `'in'` | Amount user sends |
| `OUT` | `'out'` | Amount user receives |
| `PAID` | `'paid'` | Amount actually paid |

---

## Merchant Integration

Merchants are payment processors that handle deposits and withdrawals. Create custom merchants to integrate with payment gateways.

### Direction Creation DTO

If you create directions programmatically using `LaraPluginFramework\Contracts\Direction\CreatorInterface`, your DTO implements `CreateDirectionDTOInterface`.

The following inputs accept either a simple list or detailed items:

- `getCities()`
  - `list<int>` — city IDs only
  - `list<array{id:int, coefficient:string, min_amount?:string, max_amount?:string}>`
- `getAutoWithdrawIntegrations()`
  - `list<string>` — provider codes
  - `list<array{code:string, min_amount?:string, max_amount?:string}>`

Decimal values must be strings with dot separator.

To look up withdraw providers and read their global min/max capabilities, use the repository contract:

```
use LaraPluginFramework\Contracts\Withdraw\Repository\WithdrawProviderRepositoryInterface;

/** @var WithdrawProviderRepositoryInterface $repo */

// Get all providers
$allProviders = iterator_to_array($repo->getAll());

// Get providers by codes
$providers = iterator_to_array($repo->getByCodes(['provider_a', 'provider_b']));

// Single provider by code
$single = $repo->findByCode('provider_a');

```

---

## Currency Management

### Creating a Currency

Currencies are created via the contract `LaraPluginFramework\Contracts\Currency\CreatorInterface` using a DTO that implements `CreateCurrencyDTOInterface`.

Minimal example using an anonymous DTO implementation:

```
use LaraPluginFramework\Contracts\Currency\CreatorInterface as CurrencyCreatorInterface;
use LaraPluginFramework\Contracts\Currency\DTO\CreateCurrencyDTOInterface;

/** @var CurrencyCreatorInterface $creator */
$creator = app(CurrencyCreatorInterface::class);

$usdQuoteId = 123; // ID of USD quote pair (resolve or null)

$currency = $creator->create(new class($usdQuoteId) implements CreateCurrencyDTOInterface {
    private ?int $usdQuoteId;
    public function __construct(?int $usdQuoteId) { $this->usdQuoteId = $usdQuoteId; }

    public function getShorthand(): string { return 'USDT'; }
    public function getAmount(): ?string { return null; }
    public function getMinAmountUsd(): ?string { return null; }
    public function getFromMinAmount(): ?string { return null; }
    public function getToMinAmount(): ?string { return null; }
    public function getMaxAmount(): ?string { return null; }
    public function getMerchant(): string { return 'my_merchant_code'; }
    public function getPrecision(): int { return 6; }
    public function getCategoryIds(): array { return []; }
    public function getIconId(): ?int { return null; }
    public function getBaseCurrency(): string { return 'USD'; }
    public function getMerchantTicker(): ?string { return null; }
    public function getMerchantNetwork(): ?string { return 'TRC20'; }
    public function getUsdQuoteId(): ?int { return $this->usdQuoteId; }
    public function getConfirmationsCount(): int { return 12; }
    public function getExportShorthand(): ?string { return null; }
    public function isBulkEditing(): ?bool { return null; }
    public function isTxHashInputShown(): ?bool { return null; }
    public function isRequisiteVerificationRequired(): ?bool { return null; }
    public function getMaxPayoutPeriodH(): ?int { return null; }
    public function getSocialRequiredFromAmountUsd(): ?string { return null; }
    public function getName(): ?array { return ['en' => 'Tether USD']; }
    public function getTelegramAnnotation(): ?array { return null; }
    public function getAnnotationFrom(): ?array { return null; }
    public function getAnnotationTo(): ?array { return null; }
    public function getMerchantDescription(): ?array { return null; }
    public function getCustomFields(): ?array { return null; }
});
```

Required fields
- `getShorthand(): string`
- `getMerchant(): string`
- `getPrecision(): int`
- `getCategoryIds(): list<int>` (use an empty list if none)
- `getBaseCurrency(): string` (e.g., `USD`)
- `getConfirmationsCount(): int`

Optional fields (common)
- Amount/limits: `getAmount()`, `getMinAmountUsd()`, `getFromMinAmount()`, `getToMinAmount()`, `getMaxAmount()` — decimal strings with dot separator
- Metadata: `getIconId()`, `getExportShorthand()`, localized names/annotations/description maps
- Flags: `isBulkEditing()`, `isTxHashInputShown()`, `isRequisiteVerificationRequired()`
- Other: `getMaxPayoutPeriodH()`, `getSocialRequiredFromAmountUsd()`
- Quote reference: `getUsdQuoteId()` (ID of the USD quote/pair; may be null)
- Merchant specifics: `getMerchantTicker()`, `getMerchantNetwork()`

Custom fields attachment
- Shape: `list<array{id:int, direction:string, order?:int|null, is_main_requisite?:bool}>`
- `direction` must be one of `from` or `to`.

Looking up related IDs
- Quotes: resolve the USD quote ID via your application (e.g., using `QuoteRepositoryInterface`).
- Categories: use `CategoryRepositoryInterface` to discover category IDs.
- Custom fields: use `CustomFieldRepositoryInterface` to discover custom field IDs.
- Currencies: use `CurrencyRepositoryInterface` to fetch existing currencies by ID or shorthand.

Notes
- All decimals must be string values using a dot (e.g., "1000.00").
- Creating a currency typically emits `CurrencyCreatedEventInterface`.

### Repositories (Currency domain)

The framework exposes repository contracts to read related entities:

```
use LaraPluginFramework\Contracts\Quote\Repository\QuoteRepositoryInterface;
use LaraPluginFramework\Contracts\Currency\Repository\CategoryRepositoryInterface;
use LaraPluginFramework\Contracts\Currency\Repository\CustomFieldRepositoryInterface;
use LaraPluginFramework\Contracts\Currency\Repository\CurrencyRepositoryInterface;

/** @var QuoteRepositoryInterface $quotes */
/** @var CategoryRepositoryInterface $categories */
/** @var CustomFieldRepositoryInterface $customFields */
/** @var CurrencyRepositoryInterface $currencies */

// Quotes
$quote = $quotes->findById(123);
$quotePage = $quotes->paginate(page: 1, perPage: 20);

// Categories
$allCategories = iterator_to_array($categories->all());
$someCategories = iterator_to_array($categories->getByIds([1, 2, 3]));

// Custom fields
$allFields = iterator_to_array($customFields->all());
$field = $customFields->findById(10);

// Currencies
$btc = $currencies->findByShorthand('BTC');
$byIds = iterator_to_array($currencies->getByIds([1, 2]));
```


### Creating a Merchant

Extend `AbstractMerchant` or implement `MerchantInterface`:

```php
<?php

namespace MyPlugin;

use LaraPluginFramework\Merchant\AbstractMerchant;
use LaraPluginFramework\Contracts\Context\Context;
use LaraPluginFramework\Contracts\Result\ResultInterface;
use LaraPluginFramework\Contracts\Entities\Wallet;
use LaraPluginFramework\Contracts\Entities\Currency;
use LaraPluginFramework\Contracts\Entities\Direction;
use LaraPluginFramework\Contracts\Entities\Decimal;

class MyMerchant extends AbstractMerchant
{
    private string $apiKey;
    private string $apiSecret;

    public function __construct(string $apiKey, string $apiSecret)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    /**
     * Generate payment address for customer
     */
    public function getAddress(): ?Wallet
    {
        $currency = $this->getCurrency();

        $response = $this->callApi('POST', '/addresses', [
            'currency' => $currency->getName(),
            'callback_url' => route('my-plugin.webhook'),
        ]);

        if (!$response['success']) {
            return null;
        }

        return new class($response['data']) implements Wallet {
            private array $data;

            public function __construct(array $data)
            {
                $this->data = $data;
            }

            public function getAddress(): string
            {
                return $this->data['address'];
            }

            public function getMemo(): string
            {
                return $this->data['memo'] ?? '';
            }

            public function getHash(): string
            {
                return $this->data['hash'] ?? '';
            }
        };
    }

    /**
     * Handle incoming webhook notification
     */
    public function handleNotification(Context $context): ResultInterface
    {
        $data = $context->getData();

        // Verify signature
        if (!$this->verifySignature($data)) {
            return $this->errorResult('Invalid signature');
        }

        // Process payment
        $orderId = $data['order_id'] ?? null;
        $amount = $data['amount'] ?? null;
        $status = $data['status'] ?? null;

        if ($status === 'completed') {
            // Mark payment as received
            return $this->successResult()
                ->withResponse(200, json_encode(['status' => 'ok']));
        }

        return $this->successResult();
    }

    /**
     * Verify webhook signature
     */
    private function verifySignature(array $data): bool
    {
        $signature = $data['signature'] ?? '';
        unset($data['signature']);

        $expectedSignature = hash_hmac(
            'sha256',
            json_encode($data),
            $this->apiSecret
        );

        return hash_equals($expectedSignature, $signature);
    }

    /**
     * Create notification subscription (optional)
     */
    public function createNotification(): void
    {
        // Register webhook URL with payment provider
        $this->callApi('POST', '/webhooks', [
            'url' => route('my-plugin.webhook'),
            'events' => ['payment.completed', 'payment.failed'],
        ]);
    }

    /**
     * Remove notification subscription (optional)
     */
    public function deleteNotification(): void
    {
        // Unregister webhook URL
        $this->callApi('DELETE', '/webhooks', [
            'url' => route('my-plugin.webhook'),
        ]);
    }

    private function callApi(string $method, string $endpoint, array $data = []): array
    {
        // API call implementation
    }

    private function successResult(): ResultInterface
    {
        // Return success result
    }

    private function errorResult(string $message): ResultInterface
    {
        // Return error result
    }
}
```

### Registering a Merchant

Use `MerchantRegistryInterface` to register your merchant instance by code:

```php
<?php

namespace MyPlugin\Merchant;

use LaraPluginFramework\Contracts\PluginServiceProviderInterface;
use LaraPluginFramework\Contracts\Merchant\MerchantRegistryInterface;
use LaraPluginFramework\Contracts\Merchant\Settings\MerchantSettingsValueGetterInterface;
use LaraPluginFramework\Contracts\Merchant\Settings\MerchantSettingsInterface;
use MyPlugin\Merchant\MyMerchant;
use MyPlugin\Merchant\MyMerchantSettings;

class MyPluginServiceProvider implements PluginServiceProviderInterface
{
    public function __construct(
        private readonly MerchantRegistryInterface $merchants,
        private readonly MerchantSettingsValueGetterInterface $settings,
    ) {
        $config = $this->settings->get();

        $merchant = new MyMerchant(
            $config['api_key'] ?? '',
            $config['api_secret'] ?? ''
        );

        // Register merchant by its code
        $this->merchants->add(MyMerchantSettings::getCode(), $merchant);
    }

    public function implementations(): array
    {
        return [
            MerchantSettingsInterface::class => MyMerchantSettings::class,
        ];
    }
}
```

### Handling Notifications

Use POST requests to `APP_URL` + `/notification/{merchantCode}` where `{merchantCode}` equals your `MerchantSettingsInterface::getCode()`. The `handleNotification` method receives these webhook calls from payment providers:

```php
public function handleNotification(Context $context): ResultInterface
{
    $data = $context->getData();

    // Process the notification
    // ...

    // Return response to payment provider
    return $this->result
        ->withResponse(
            200,                              // HTTP status code
            json_encode(['status' => 'ok']),  // Response body
            ['Content-Type' => 'application/json']  // Headers
        );
}
```

### Merchant Settings

Define merchant-specific settings:

```php
<?php

namespace MyPlugin\Merchant;

use LaraPluginFramework\Contracts\Merchant\Settings\MerchantSettingsInterface;
use LaraPluginFramework\Fields\FieldBuilder;

class MyMerchantSettings implements MerchantSettingsInterface
{
    public static function getCode(): string
    {
        return 'my_merchant';
    }

    public static function getName(): string
    {
        return 'My Merchant';
    }

    public function getSchema(): ?array
    {
        return [
            'api_key' => (new FieldBuilder())
                ->password('api_key')
                ->label('API Key')
                ->required()
                ->build()
                ->toArray(),

            'api_secret' => (new FieldBuilder())
                ->password('api_secret')
                ->label('API Secret')
                ->required()
                ->build()
                ->toArray(),

            'webhook_secret' => (new FieldBuilder())
                ->password('webhook_secret')
                ->label('Webhook Secret')
                ->required()
                ->helperText('Used to verify incoming webhooks')
                ->build()
                ->toArray(),
        ];
    }

    public function getSensitiveKeys(): array
    {
        return ['api_key', 'api_secret', 'webhook_secret'];
    }
}
```

---

## Rate Providers

Rate providers supply exchange rates from external sources.

### Creating a Rate Provider

Implement `RateProviderInterface`:

```php
<?php

namespace MyPlugin\Rates;

use LaraPluginFramework\Contracts\Rates\RateProviderInterface;
use LaraPluginFramework\Contracts\Entities\Rate;
use LaraPluginFramework\Contracts\Entities\Decimal;
use Traversable;
use ArrayIterator;

class MyRateProvider implements RateProviderInterface
{
    private string $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * @return Traversable<Rate>
     */
    public function getAll(): Traversable
    {
        $rates = $this->fetchRatesFromApi();

        $result = [];

        foreach ($rates as $pair => $value) {
            $result[] = new class($pair, $value) implements Rate {
                private string $pair;
                private string $value;

                public function __construct(string $pair, string $value)
                {
                    $this->pair = $pair;
                    $this->value = $value;
                }

                public function getProvider(): string
                {
                    return 'my_provider';
                }

                public function getName(): string
                {
                    return $this->pair;  // e.g., 'BTC/USD'
                }

                public function getValue(): Decimal
                {
                    // Return Decimal implementation
                    return new MyDecimal($this->value);
                }
            };
        }

        return new ArrayIterator($result);
    }

    private function fetchRatesFromApi(): array
    {
        $response = file_get_contents(
            "https://api.myprovider.com/rates?api_key={$this->apiKey}"
        );

        return json_decode($response, true)['rates'] ?? [];
    }
}
```

### Registering Rate Providers

Register your provider with the composite rate provider:

```php
// In your plugin initialization
use LaraPluginFramework\Contracts\Rates\CompositeRateProviderInterface;

$compositeProvider = $container->get(CompositeRateProviderInterface::class);
$compositeProvider->add(new MyRateProvider($apiKey));
```

---

## Order Service

The order service allows plugins to read and modify orders.

### Reading Orders

Use `OrderRepositoryInterface`:

```php
use LaraPluginFramework\Contracts\Order\Repository\OrderRepositoryInterface;

class MyService
{
    public function __construct(
        private readonly OrderRepositoryInterface $orderRepository
    ) {}

    public function processOrder(string $hash): void
    {
        // Find by hash
        $order = $this->orderRepository->findByHash($hash);

        if (!$order) {
            throw new \Exception('Order not found');
        }

        // Access order properties
        $id = $order->getId();
        $fromAmount = $order->fromAmount();
        $toAmount = $order->toAmount();
        $fromCurrency = $order->fromCurrency();
        $toCurrency = $order->toCurrency();
        $rate = $order->rate();
        $status = $order->status();
    }
}
```

### Modifying Orders

Use `OrderServiceInterface`:

```php
use LaraPluginFramework\Contracts\Order\Service\OrderServiceInterface;
use LaraPluginFramework\Enums\OrderStatusEnum;

class MyService
{
    public function __construct(
        private readonly OrderServiceInterface $orderService,
        private readonly OrderRepositoryInterface $orderRepository
    ) {}

    public function completeOrder(int $orderId): void
    {
        $order = $this->orderRepository->findById($orderId);

        // Change status
        $result = $this->orderService->setStatus(
            $order,
            OrderStatusEnum::COMPLETED_STATUS
        );

        if (!$result->isSuccessful()) {
            throw new \Exception($result->getErrorMessage());
        }
    }

    public function updateOrderAmount(int $orderId, string $paidAmount): void
    {
        $order = $this->orderRepository->findById($orderId);

        // Create Decimal from string
        $amount = $this->createDecimal($paidAmount);

        // Update paid amount
        $this->orderService->changePaidAmount($order, $amount);
    }

    public function recalculateOrder(int $orderId): void
    {
        $order = $this->orderRepository->findById($orderId);

        // Trigger recalculation
        $this->orderService->recalculate($order);
    }
}
```

**Available Order Service Methods:**

| Method | Description |
|--------|-------------|
| `setStatus(Order, OrderStatusEnum, bool)` | Change order status |
| `recalculate(Order)` | Recalculate order amounts |
| `charge(Order, Decimal)` | Apply a charge |
| `changeIn(Order, Decimal)` | Change input amount |
| `changeOut(Order, Decimal)` | Change output amount |
| `changePaidAmount(Order, Decimal)` | Update paid amount |
| `changeTransactionHash(Order, string)` | Set transaction hash |
| `setHash(Order, string)` | Set order hash |

---

## Entities Reference

### Order Status Enum

```php
enum OrderStatusEnum: int
{
    case CREATED_STATUS = 0;
    case USER_APPROVED_STATUS = 1;
    case WAITING_STATUS = 2;
    case PAID_STATUS = 3;
    case DELETED_STATUS = 4;
    case ERROR_STATUS = 5;
    case CHECK_STATUS = 6;
    case CANCELLED_STATUS = 7;
    case COMPLETED_STATUS = 8;
    case WAITING_AUTO_WITHDRAWS_STATUS = 9;
    case ERROR_AUTO_WITHDRAWS_STATUS = 10;
    case AML_CHECK_STATUS = 11;
    case PARTIALLY_PROCESSED_AUTO_WITHDRAWS_STATUS = 12;
}
```

### Verification Status Enum

```php
enum VerificationStatusEnum: int
{
    case IN_PROGRESS = 1;
    case NON_VERIFIED = 2;
    case DECLINED = 3;
    case APPROVED = 4;
}
```

### Withdraw Status Enum

```php
enum WithdrawStatusEnum: int
{
    case CREATED = 0;
    case PAID = 1;
    case CANCELLED = 2;
    case CANCELLED_BY_USER = 3;
}
```

### Decimal Interface

For high-precision financial calculations:

```php
interface Decimal
{
    public function getPrecision(): int;
    public function withMaxPrecision(): self;
    public function withPrecision(int $precision): self;

    // Arithmetic
    public function add(self $value): self;
    public function sub(self $value): self;
    public function multiply(self $value): self;
    public function divide(self $value): self;
    public function percent(self $percent): self;

    // Comparisons
    public function less(self $decimal): bool;
    public function lessOrEqual(self $decimal): bool;
    public function greater(self $decimal): bool;
    public function greaterOrEqual(self $decimal): bool;
    public function equals(self $decimal): bool;

    // Utilities
    public function getValue(): string;
    public function isZero(): bool;
    public function round(int $precision): string;
}
```

---

## Best Practices

### Security

1. **Always encrypt sensitive data** - API keys, secrets, tokens
2. **Verify webhook signatures** - Prevent unauthorized requests
3. **Validate all input** - Check types and bounds
4. **Use prepared statements** - Prevent SQL injection

### Performance

1. **Cache expensive operations** - API calls, calculations
2. **Use database transactions** - For multi-step operations
3. **Batch operations** - When processing multiple items

### Error Handling

1. **Log errors with context** - Include order IDs, amounts
2. **Return meaningful error messages** - Help debugging
3. **Gracefully handle failures** - Don't crash the system

### Code Organization

```php
// Good: Single responsibility
class OrderStatusChecker { /* ... */ }
class PaymentProcessor { /* ... */ }
class WebhookHandler { /* ... */ }

// Bad: God class
class DoEverything { /* ... */ }
```

---

## Examples

### Complete Plugin Example

A full working example of a simple notification plugin:

```php
<?php
// src/NotificationPluginServiceProvider.php

namespace NotificationPlugin;

use LaraPluginFramework\Contracts\PluginServiceProviderInterface;
use LaraPluginFramework\Contracts\SettingsGetterInterface;
use LaraPluginFramework\Contracts\SettingsSaverInterface;
use LaraPluginFramework\Contracts\SettingsValueGetterInterface;

class NotificationPluginServiceProvider implements PluginServiceProviderInterface
{
    public function implementations(): array
    {
        return [
            SettingsGetterInterface::class => Settings\SettingsGetter::class,
            SettingsSaverInterface::class => Settings\SettingsSaver::class,
            SettingsValueGetterInterface::class => Settings\SettingsValueGetter::class,
        ];
    }
}
```

```php
<?php
// src/Settings/SettingsGetter.php

namespace NotificationPlugin\Settings;

use LaraPluginFramework\Contracts\SettingsGetterInterface;
use LaraPluginFramework\Fields\FieldBuilder;

class SettingsGetter implements SettingsGetterInterface
{
    public function get(): string
    {
        return json_encode([
            'telegram_bot_token' => (new FieldBuilder())
                ->password('telegram_bot_token')
                ->label('Telegram Bot Token')
                ->required()
                ->build()
                ->toArray(),

            'telegram_chat_id' => (new FieldBuilder())
                ->text('telegram_chat_id')
                ->label('Telegram Chat ID')
                ->required()
                ->build()
                ->toArray(),

            'notify_on_new_order' => (new FieldBuilder())
                ->select('notify_on_new_order')
                ->label('Notify on New Orders')
                ->options([
                    ['value' => 'yes', 'label' => 'Yes'],
                    ['value' => 'no', 'label' => 'No'],
                ])
                ->default('yes')
                ->build()
                ->toArray(),
        ]);
    }
}
```

```php
<?php
// src/Listeners/OrderCreatedListener.php

namespace NotificationPlugin\Listeners;

use LaraPluginFramework\Contracts\Events\OrderChangeStatusEventInterface;
use LaraPluginFramework\Enums\OrderStatusEnum;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class OrderCreatedListener
{
    public function handle(OrderChangeStatusEventInterface $event): void
    {
        // Only handle new orders
        if ($event->newStatus() !== OrderStatusEnum::CREATED_STATUS) {
            return;
        }

        $settings = $this->getSettings();

        if ($settings['notify_on_new_order'] !== 'yes') {
            return;
        }

        $order = $event->order();

        $message = sprintf(
            "New order #%d\nFrom: %s %s\nTo: %s %s",
            $order->getId(),
            $order->fromAmount()->getValue(),
            $order->fromCurrency()->getName(),
            $order->toAmount()->getValue(),
            $order->toCurrency()->getName()
        );

        $this->sendTelegramMessage(
            $settings['telegram_bot_token'],
            $settings['telegram_chat_id'],
            $message
        );
    }

    private function getSettings(): array
    {
        $settings = DB::table('notification_plugin_settings')
            ->where('key', 'main')
            ->first();

        return $settings ? (array) $settings : [];
    }

    private function sendTelegramMessage(string $token, string $chatId, string $message): void
    {
        Http::post("https://api.telegram.org/bot{$token}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML',
        ]);
    }
}
```

### Plugin Structure

A typical plugin follows this directory structure:

```
my-plugin/
├── src/
│   ├── MyPluginServiceProvider.php
│   ├── Settings/
│   │   ├── SettingsGetter.php
│   │   ├── SettingsSaver.php
│   │   └── SettingsValueGetter.php
│   ├── Merchant/
│   │   ├── MyMerchant.php
│   │   └── MyMerchantSettings.php
│   ├── Listeners/
│   │   └── OrderStatusListener.php
│   └── Rates/
│       └── MyRateProvider.php
├── database/
│   └── migrations/
│       └── 2024_01_01_000000_create_my_plugin_tables.php
├── config/
│   └── my-plugin.php
├── manifest.php
├── index.php
└── composer.json
```

#### Mandatory Plugin Structure

NOTE: For the loader to work correctly, the plugin must include at least the following files and paths:

```
my-plugin/
├── config/
│   └── schema.json   # required: JSON schema for the settings form
├── manifest.php      # required: plugin manifest
└── src/
    └── Providers/
        └── MyPluginServiceProvider.php  # service provider class
```

Minimal `manifest.php` example (keys expected by the loader):

```php
<?php

return [
    // Version and basic metadata
    'version' => '1.0.0',
    'title' => 'My Plugin',
    'description' => 'Short description',
    'author' => 'Your Name',

    // Required: fully-qualified service provider class path
    'provider_path' => 'MyPlugin\\Providers\\MyPluginServiceProvider',

    // Required: path to the settings JSON schema relative to plugin root
    'settings_schema' => 'config/schema.json',

    // Optional but recommended (if you ship migrations)
    'migration_path' => 'database/migrations',

    // Optional extras (as needed)
    'categories' => ['example'],
    'scopes' => ['example:scope'],
];
```

Minimal `config/schema.json` example (settings form structure):

```json
{
  "settings": [
    {
      "type": "tab",
      "name": "General",
      "id": "general",
      "fields": {
        "example_field": {
          "type": "text",
          "label": "Example field",
          "required": false
        }
      }
    }
  ]
}
```

---

## Support

For questions and support:
- Check the [lara-plugin-framework](https://github.com/cakealliance/lara-plugin-framework) repository
- Contact the development team

---

*Last updated: March 2026*
