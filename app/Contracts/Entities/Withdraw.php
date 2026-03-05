<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Entities;

use LaraPluginFramework\Enums\WithdrawStatusEnum;

interface Withdraw
{
    public function getId(): int;

    public function getUserId(): int;

    public function getAmount(): Decimal;

    public function getCurrencyId(): int;

    public function getStatus(): WithdrawStatusEnum;

    public function getWallet(): string;
}
