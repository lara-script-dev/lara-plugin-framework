<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Order\Service;

use LaraPluginFramework\Contracts\Entities\Decimal;
use LaraPluginFramework\Contracts\Entities\Order;
use LaraPluginFramework\Contracts\Result\ResultInterface;
use LaraPluginFramework\Enums\OrderStatusEnum;

interface OrderServiceInterface
{
    public function setStatus(Order $order, OrderStatusEnum $status, bool $silently = false): ResultInterface;

    public function recalculate(Order $order): ResultInterface;

    public function charge(Order $order, Decimal $amount): ResultInterface;

    public function changeIn(Order $order, Decimal $amount): ResultInterface;

    public function changeOut(Order $order, Decimal $amount): ResultInterface;

    public function changePaidAmount(Order $order, Decimal $amount): ResultInterface;

    public function changeTransactionHash(Order $order, string $value): ResultInterface;

    public function setHash(Order $order, string $hash): ResultInterface;
}
