<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Merchant;

interface MerchantRegistryInterface
{
    public function add(string $code, MerchantInterface $merchant): void;

    public function findByCode(string $code): ?MerchantInterface;
}

