<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Merchant\Settings;

/**
 * Provides persisted settings values for a specific merchant.
 */
interface MerchantSettingsValueGetterInterface
{
    /**
     * Fetch stored settings for the merchant identified by code.
     *
     * Implementations typically load values from the database.
     *
     * @param non-empty-string $merchantCode Merchant machine code (e.g. 'oasis').
     * @return array<string, mixed> Key-value settings for the merchant.
     */
    public function get(string $merchantCode): array;
}

