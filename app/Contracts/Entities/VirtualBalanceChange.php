<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Entities;

use LaraPluginFramework\Enums\VirtualBalanceChangeTypeEnum;

interface VirtualBalanceChange
{
    public function getId(): int;

    public function getChangeType(): VirtualBalanceChangeTypeEnum;

    public function getOldBalance(): Decimal;

    public function getNewBalance(): Decimal;

    public function getDifference(): Decimal;

    public function getAdminUserId(): ?int;

    public function getOrderId(): ?int;

    public function getComment(): ?string;
}
