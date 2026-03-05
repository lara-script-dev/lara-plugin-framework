<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Direction\Repository;

use LaraPluginFramework\Contracts\Entities\Direction;

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
}
