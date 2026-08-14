<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Currency\Repository;

use LaraPluginFramework\Contracts\Entities\Category;

interface CategoryRepositoryInterface
{
    /**
     * @param int $id
     */
    public function findById(int $id): ?Category;

    /**
     * @param list<int> $ids
     * @return iterable<Category>
     */
    public function getByIds(array $ids): iterable;

    /**
     * @return iterable<Category>
     */
    public function all(): iterable;

    /**
     * Category IDs the currency belongs to, ordered by category priority descending.
     *
     * @return list<int>
     */
    public function getIdsByCurrencyId(int $currencyId): array;
}

