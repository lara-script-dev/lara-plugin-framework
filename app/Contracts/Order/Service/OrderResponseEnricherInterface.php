<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Order\Service;

use LaraPluginFramework\Contracts\Entities\Order;

interface OrderResponseEnricherInterface
{
    /**
     * @return array<string, mixed>
     */
    public function enrich(Order $order): array;
}
