<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Merchant\CheckStatus;

use LaraPluginFramework\Contracts\Entities\Order;

interface CheckStatusInterface
{
    /**
     * Merchant code (e.g. 'oasis', 'heleket').
     */
    public function getMerchantCode(): string;

    /**
     * Return numeric order statuses to check.
     * Provide integer values of OrderStatusEnum cases (e.g. OrderStatusEnum::WAITING_STATUS->value).
     *
     * @return int[]
     */
    public function getOrderStatusesToCheck(): array;

    /**
     * Execute status check for provided orders.
     *
     * @param iterable<Order> $orders Traversable collection of orders
     */
    public function execute(iterable $orders): void;
}
