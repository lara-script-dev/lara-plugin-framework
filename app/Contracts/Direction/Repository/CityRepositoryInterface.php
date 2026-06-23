<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Direction\Repository;

use LaraPluginFramework\Contracts\Entities\City;

interface CityRepositoryInterface
{
    public function findById(int $id): ?City;

    public function findByCode(string $code): ?City;

    /**
     * @param list<int> $ids
     * @return iterable<City>
     */
    public function getByIds(array $ids): iterable;
}
