<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Merchant\Settings;

use LaraPluginFramework\Fields\FieldDTO;

interface MerchantSettingsInterface
{
    /**
     * Unique machine code of the merchant (e.g. 'oasis').
     */
    public static function getCode(): string;

    /**
     * Human readable name (e.g. 'Oasis').
     */
    public static function getName(): string;

    /**
     * Build settings schema for UI rendering.
     *
     * Recommended: return an associative array where keys are setting names and
     * values are FieldDTO instances built via FieldBuilder.
     * Example:
     *   return [
     *     'api_key' => (new \LaraPluginFramework\Fields\FieldBuilder())
     *         ->password('api_key')
     *         ->label('API key')
     *         ->required()
     *         ->build(),
     *     'organization_id' => (new \LaraPluginFramework\Fields\FieldBuilder())
     *         ->text('organization_id')
     *         ->label('Organization id')
     *         ->required()
     *         ->build(),
     *   ];
     *
     * When serializing, each FieldDTO can be converted to array via toArray().
     *
     * @return array<string, FieldDTO>|null
     */
    public function getSchema(): ?array;

    /**
     * @return string[] keys that should be masked/hidden
     */
    public function getSensitiveKeys(): array;
}
