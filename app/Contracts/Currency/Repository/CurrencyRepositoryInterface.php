<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Currency\Repository;

use LaraPluginFramework\Contracts\Entities\Currency;

interface CurrencyRepositoryInterface
{
    /**
     * @param int $id
     */
    public function findById(int $id): ?Currency;

    /**
     * Find a currency by public shorthand, e.g. "BTC".
     */
    public function findByShorthand(string $shorthand): ?Currency;

    /**
     * @param list<int> $ids
     * @return iterable<Currency>
     */
    public function getByIds(array $ids): iterable;
}

