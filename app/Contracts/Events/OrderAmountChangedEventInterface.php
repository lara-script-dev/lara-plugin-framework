<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Events;

use LaraPluginFramework\Contracts\Entities\AdminUser;
use LaraPluginFramework\Contracts\Entities\Decimal;
use LaraPluginFramework\Contracts\Entities\Order;
use LaraPluginFramework\Enums\OrderAmountTypeEnum;

interface OrderAmountChangedEventInterface
{
    public function order(): Order;

    public function amountType(): OrderAmountTypeEnum;

    public function oldAmount(): Decimal;

    public function newAmount(): Decimal;

    public function author(): ?AdminUser;
}
