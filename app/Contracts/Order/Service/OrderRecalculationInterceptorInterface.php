<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Order\Service;

use LaraPluginFramework\Contracts\Entities\Order;
use LaraPluginFramework\DTO\OrderRecalculationInterceptorResult;

interface OrderRecalculationInterceptorInterface
{
    /**
     * Adjust the OUT amount during order recalculation or in-amount change.
     *
     * @param Order $order Order entity to look up plugin-specific metadata
     * @param string $inAmount The order's IN amount
     * @param string $outAmount The default calculated OUT amount (in * rate)
     * @param string $rate The order's current rate
     */
    public function adjustOut(
        Order $order,
        string $inAmount,
        string $outAmount,
        string $rate,
    ): OrderRecalculationInterceptorResult;
}
