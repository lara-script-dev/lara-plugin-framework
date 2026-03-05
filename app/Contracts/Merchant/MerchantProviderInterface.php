<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Merchant;

use LaraPluginFramework\Contracts\Entities\Currency;
use LaraPluginFramework\Contracts\Entities\Direction;

interface MerchantProviderInterface
{
    public function findByDirection(Direction $direction): ?MerchantInterface;

    public function findByCurrency(Currency $currency): ?MerchantInterface;
}

