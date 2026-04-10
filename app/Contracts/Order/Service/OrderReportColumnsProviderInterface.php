<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Order\Service;

use LaraPluginFramework\Contracts\Entities\Order;

interface OrderReportColumnsProviderInterface
{
    /**
     * Return column headers for the report.
     *
     * @return array<string>
     */
    public function getHeaders(string $langCode): array;

    /**
     * Return cell values for a specific order.
     *
     * @return array<mixed>
     */
    public function getValues(Order $order): array;
}
