<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Events;

use LaraPluginFramework\Contracts\Entities\AdminUser;
use LaraPluginFramework\Contracts\Entities\Withdraw;
use LaraPluginFramework\Enums\WithdrawStatusEnum;

interface WithdrawUpdatedEventInterface
{
    public function withdraw(): Withdraw;

    public function oldStatus(): WithdrawStatusEnum;

    public function newStatus(): WithdrawStatusEnum;

    public function author(): ?AdminUser;
}
