<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Events;

use LaraPluginFramework\Contracts\Entities\AdminUser;
use LaraPluginFramework\Contracts\Entities\Order;
use LaraPluginFramework\Enums\OrderStatusEnum;

interface OrderChangeStatusEventInterface
{
    public function oldStatus(): ?OrderStatusEnum;
    public function newStatus(): OrderStatusEnum;
    public function order(): Order;
    public function author(): ?AdminUser;
}
