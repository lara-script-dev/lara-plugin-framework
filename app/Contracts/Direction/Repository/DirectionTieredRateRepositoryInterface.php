<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Direction\Repository;

use LaraPluginFramework\DTO\Filters;
use LaraPluginFramework\DTO\TieredRate\DirectionTieredRates;
use LaraPluginFramework\DTO\TieredRate\DirectionTieredRatesChange;
use LaraPluginFramework\DTO\TieredRate\DirectionTieredRatesPage;
use LaraPluginFramework\DTO\TieredRate\TieredRate;
use LaraPluginFramework\Enums\TieredRateAmountSideEnum;

/**
 * Reads and writes the tiered rates the core stores for directions.
 */
interface DirectionTieredRateRepositoryInterface
{
    /**
     * Directions that have tiers, filtered like `DirectionRepositoryInterface::getIdsByFilters`
     * plus `active` (tiered rates switched on for the direction).
     */
    public function paginate(Filters $filters, ?int $page = null, ?int $perPage = null): DirectionTieredRatesPage;

    /**
     * Settings of the given directions whether they have tiers or not; unknown ids are skipped.
     *
     * @param list<int> $directionIds
     * @return array<int, DirectionTieredRates> keyed by direction id
     */
    public function getByDirectionIds(array $directionIds): array;

    /**
     * @param list<int> $directionIds
     * @return list<int> the given directions that have at least one tier
     */
    public function getDirectionIdsWithTiers(array $directionIds): array;

    /**
     * Validates a full set of tiers with the rules the direction form applies, for the side
     * the bounds are expressed in.
     *
     * @param list<TieredRate> $tiers
     * @return array<string, string> messages keyed by "{index}.{field}", or "tiers" for the set as a whole
     */
    public function validate(array $tiers, TieredRateAmountSideEnum $amountSide): array;

    /**
     * Applies the changes in one transaction; tiers must have passed `validate()`. Changing `amountSide`
     * of a direction that has tiers requires `tiers` in the same change, otherwise the whole save is rejected.
     *
     * @param array<int, DirectionTieredRatesChange> $changes keyed by direction id
     * @return int number of directions changed
     */
    public function save(array $changes): int;

    /**
     * @param list<int> $directionIds
     * @return int number of directions whose tiers were deleted
     */
    public function deleteTiers(array $directionIds): int;
}
