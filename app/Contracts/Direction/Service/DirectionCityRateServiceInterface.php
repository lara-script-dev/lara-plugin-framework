<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Direction\Service;

use LaraPluginFramework\Contracts\Entities\Decimal;
use LaraPluginFramework\Contracts\Entities\Direction;
use LaraPluginFramework\Contracts\Result\ResultInterface;

interface DirectionCityRateServiceInterface
{
    /**
     * Updates the fixed exchange rate for one city attached to a direction.
     */
    public function setFixedRate(
        Direction $direction,
        int $cityId,
        Decimal $rate,
    ): ResultInterface;
}
