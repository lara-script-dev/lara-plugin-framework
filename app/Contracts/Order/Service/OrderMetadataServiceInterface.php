<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Order\Service;

use LaraPluginFramework\Contracts\Entities\Order;

interface OrderMetadataServiceInterface
{
    public function set(Order $order, string $key, mixed $value): void;

    public function get(Order $order, string $key, mixed $default = null): mixed;

    public function has(Order $order, string $key): bool;
}
