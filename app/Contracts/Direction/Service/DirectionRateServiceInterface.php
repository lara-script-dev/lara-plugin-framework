<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Direction\Service;

use LaraPluginFramework\Contracts\Entities\Decimal;
use LaraPluginFramework\Contracts\Entities\Direction;
use LaraPluginFramework\Contracts\Result\ResultInterface;

interface DirectionRateServiceInterface
{
    /**
     * Updates the effective exchange rate for a direction.
     */
    public function setRate(Direction $direction, Decimal $rate): ResultInterface;
}
