<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts;

interface OperatorStatusProviderInterface
{
    public function isOnline(): bool;
}
