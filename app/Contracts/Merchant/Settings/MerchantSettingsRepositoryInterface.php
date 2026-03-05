<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Merchant\Settings;

interface MerchantSettingsRepositoryInterface
{
    public function add(string $code, MerchantSettingsInterface $provider): void;

    public function get(string $code): ?MerchantSettingsInterface;
}

