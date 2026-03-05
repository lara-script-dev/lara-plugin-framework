<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Events;

use LaraPluginFramework\Contracts\Entities\AdminUser;
use LaraPluginFramework\Contracts\Entities\Order;

interface OrderUnassignedEventInterface
{
    public function order(): Order;

    public function unassignedAdmin(): AdminUser;

    public function author(): ?AdminUser;
}
