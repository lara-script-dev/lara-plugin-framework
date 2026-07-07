<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Events;

use LaraPluginFramework\Contracts\Entities\Decimal;
use LaraPluginFramework\Contracts\Entities\Order;

interface OrderOasisPayoutSafeguardEventInterface
{
    public function order(): Order;
    public function usdtIn(): Decimal;
    public function usdtOut(): Decimal;
    public function absoluteDeviation(): Decimal;
    public function deviationPercent(): Decimal;
    public function exchangeRate(): Decimal;
}
