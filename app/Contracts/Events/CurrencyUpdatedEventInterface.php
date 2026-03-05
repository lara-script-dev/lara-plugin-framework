<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Events;

use LaraPluginFramework\Contracts\Entities\AdminUser;
use LaraPluginFramework\Contracts\Entities\Currency;

interface CurrencyUpdatedEventInterface
{
    public function currency(): Currency;

    public function author(): ?AdminUser;
}
