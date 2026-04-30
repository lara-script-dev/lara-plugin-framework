<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Direction\Repository;

use LaraPluginFramework\Contracts\Entities\Direction;
use LaraPluginFramework\DTO\Filters;

interface DirectionRepositoryInterface
{
    /**
     * @param int $id
     */
    public function findById(int $id): ?Direction;

    /**
     * @param list<int> $ids
     * @return iterable<Direction>
     */
    public function getByIds(array $ids): iterable;

    /**
     * Returns direction identifiers that satisfy the provided filter set.
     *
     * @return list<int>
     */
    public function getIdsByFilters(Filters $filters): array;
}
