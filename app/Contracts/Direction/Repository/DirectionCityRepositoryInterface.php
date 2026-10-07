<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Direction\Repository;

use LaraPluginFramework\Contracts\Entities\DirectionCity;

interface DirectionCityRepositoryInterface
{
    public function find(int $directionId, int $cityId): ?DirectionCity;

    /**
     * @return iterable<DirectionCity>
     */
    public function getByDirectionId(int $directionId, bool $onlyEnabledCities = true): iterable;

    /**
     * @param list<int> $directionIds
     * @return iterable<DirectionCity>
     */
    public function getByDirectionIds(array $directionIds, bool $onlyEnabledCities = true): iterable;

    /**
     * Decimal places the city fixed rate keeps once stored and exported; the rest is truncated.
     */
    public function getFixedRatePrecision(int $directionId, int $cityId): int;
}
