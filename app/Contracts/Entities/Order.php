<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Entities;

use LaraPluginFramework\Enums\OrderStatusEnum;

interface Order
{
    public function getId(): int;
    public function fromAmount(): Decimal;
    public function toAmount(): Decimal;
    public function fromCurrency(): Currency;
    public function toCurrency(): Currency;
    public function rate(): Decimal;
    public function status(): OrderStatusEnum;
}
