<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Withdraw\Provider;

use LaraPluginFramework\Contracts\Entities\Decimal;

interface WithdrawProviderInterface
{
    public function getId(): int;

    /**
     * Unique provider code (slug/key) used in configs and APIs.
     */
    public function getCode(): string;
}

