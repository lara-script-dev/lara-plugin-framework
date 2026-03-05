<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Events;

use LaraPluginFramework\Contracts\Entities\AdminUser;
use LaraPluginFramework\Contracts\Entities\Order;
use LaraPluginFramework\Enums\OrderRequisiteTypeEnum;

interface OrderRequisiteChangedEventInterface
{
    public function order(): Order;

    public function requisiteType(): OrderRequisiteTypeEnum;

    public function oldValue(): string;

    public function newValue(): string;

    public function author(): ?AdminUser;
}
