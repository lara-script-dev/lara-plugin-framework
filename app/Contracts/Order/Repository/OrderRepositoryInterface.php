<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Order\Repository;

use LaraPluginFramework\Contracts\Entities\Order;

interface OrderRepositoryInterface
{
    public function findByHash(string $hash): ?Order;

    public function findById(int $id): ?Order;
}

