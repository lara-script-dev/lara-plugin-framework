<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Events;

use LaraPluginFramework\Contracts\Entities\AdminUser;
use LaraPluginFramework\Contracts\Entities\Order;

interface OrderReceiptDeletedEventInterface
{
    public function order(): Order;

    public function author(): ?AdminUser;
}
