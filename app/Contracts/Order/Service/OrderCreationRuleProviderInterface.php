<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Order\Service;

interface OrderCreationRuleProviderInterface
{
    /**
     * Validation rules to merge into order creation request.
     *
     * @return array<string, array<int, mixed>>
     */
    public function rules(): array;
}
