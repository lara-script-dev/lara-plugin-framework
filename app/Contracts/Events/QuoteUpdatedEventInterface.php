<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Events;

use LaraPluginFramework\Contracts\Entities\AdminUser;
use LaraPluginFramework\Contracts\Entities\Quote;

interface QuoteUpdatedEventInterface
{
    public function quote(): Quote;

    public function author(): ?AdminUser;
}
