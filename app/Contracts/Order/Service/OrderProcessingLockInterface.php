<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Order\Service;

use LaraPluginFramework\Contracts\Entities\Order;

/**
 * Per-order lock shared with the core status pollers and merchant webhooks. Do the merchant
 * HTTP calls before taking it and write the order inside the callback.
 */
interface OrderProcessingLockInterface
{
    /**
     * Runs the callback with the order re-read under the lock; it may be re-run, so it only writes
     * to the database. Returns false without running it when another worker holds the order, the
     * order is gone or its status is no longer one of $expectedStatuses.
     *
     * @param callable(Order): void $callback
     * @param int[] $expectedStatuses OrderStatusEnum values the order was selected in; empty skips the check
     */
    public function withLockedOrder(Order $order, string $context, callable $callback, array $expectedStatuses = []): bool;
}
