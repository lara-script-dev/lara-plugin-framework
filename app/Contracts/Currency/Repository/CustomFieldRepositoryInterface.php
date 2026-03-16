<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Currency\Repository;

use LaraPluginFramework\Contracts\Entities\CustomField;

interface CustomFieldRepositoryInterface
{
    /**
     * @param int $id
     */
    public function findById(int $id): ?CustomField;

    /**
     * @param list<int> $ids
     * @return iterable<CustomField>
     */
    public function getByIds(array $ids): iterable;

    /**
     * @return iterable<CustomField>
     */
    public function all(): iterable;
}

