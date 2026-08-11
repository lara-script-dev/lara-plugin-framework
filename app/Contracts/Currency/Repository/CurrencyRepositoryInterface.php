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
     * Find a canonical currency record by its base asset code, e.g. "USDT".
     *
     * This is used when an aggregate wallet balance has no network context.
     */
    public function findByBaseCurrency(string $baseCurrency): ?Currency;

    /**
     * @param list<int> $ids
     * @return iterable<Currency>
     */
    public function getByIds(array $ids): iterable;
}
