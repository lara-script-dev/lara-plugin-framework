<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Quote\Repository;

use LaraPluginFramework\Contracts\Entities\Quote;

interface QuoteRepositoryInterface
{
    /**
     * @param int $id
     */
    public function findById(int $id): ?Quote;

    /**
     * @param list<int> $ids
     * @return iterable<Quote>
     */
    public function getByIds(array $ids): iterable;

    /**
     * Paginated listing of quotes without framework coupling.
     *
     * @return array{
     *   items: iterable<Quote>,
     *   total: int,
     *   per_page: int,
     *   current_page: int,
     *   last_page: int
     * }
     */
    public function paginate(int $page = 1, int $perPage = 15): array;
}
