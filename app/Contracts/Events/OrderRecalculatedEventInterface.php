<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Events;

use LaraPluginFramework\Contracts\Entities\AdminUser;
use LaraPluginFramework\Contracts\Entities\Decimal;
use LaraPluginFramework\Contracts\Entities\Order;

interface OrderRecalculatedEventInterface
{
    public function order(): Order;

    public function oldRate(): Decimal;

    public function newRate(): Decimal;

    public function author(): ?AdminUser;
}
