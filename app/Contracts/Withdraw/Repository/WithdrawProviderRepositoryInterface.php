<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Withdraw\Repository;

use LaraPluginFramework\Contracts\Withdraw\Provider\WithdrawProviderInterface;

interface WithdrawProviderRepositoryInterface
{
    /**
     * Find provider by its unique code.
     */
    public function findByCode(string $code): ?WithdrawProviderInterface;

    /**
     * Get providers by their unique codes.
     *
     * @param list<string> $codes
     * @return iterable<WithdrawProviderInterface>
     */
    public function getByCodes(array $codes): iterable;

    /**
     * Get all withdraw providers.
     *
     * @return iterable<WithdrawProviderInterface>
     */
    public function getAll(): iterable;
}
