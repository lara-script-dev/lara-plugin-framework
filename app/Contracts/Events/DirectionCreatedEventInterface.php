<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Events;

use LaraPluginFramework\Contracts\Entities\AdminUser;
use LaraPluginFramework\Contracts\Entities\Direction;

interface DirectionCreatedEventInterface
{
    public function direction(): Direction;

    public function author(): ?AdminUser;
}
