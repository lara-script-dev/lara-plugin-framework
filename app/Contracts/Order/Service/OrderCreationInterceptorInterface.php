<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Order\Service;

use LaraPluginFramework\DTO\OrderCreationInterceptorResult;

interface OrderCreationInterceptorInterface
{
    /**
     * Intercept order creation to modify amounts or attach metadata.
     *
     * @param array<string, mixed> $requestData Full HTTP request input
     */
    public function intercept(
        int $directionId,
        string $inAmount,
        string $outAmount,
        array $requestData,
    ): OrderCreationInterceptorResult;
}
