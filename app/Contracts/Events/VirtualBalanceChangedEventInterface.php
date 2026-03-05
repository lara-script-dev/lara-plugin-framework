<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Events;

use LaraPluginFramework\Contracts\Entities\AdminUser;
use LaraPluginFramework\Contracts\Entities\VirtualBalanceChange;

interface VirtualBalanceChangedEventInterface
{
    public function virtualBalanceChange(): VirtualBalanceChange;

    public function author(): ?AdminUser;
}
