<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Rates;

use LaraPluginFramework\Contracts\Entities\Rate;
use Traversable;

interface RateProviderInterface
{
    /**
     * @return Traversable<Rate>
     */
    public function getAll(): Traversable;
}

