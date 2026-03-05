<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Merchant\CheckStatus;

interface CheckStatusCompositeInterface
{
    /**
     * Register a status checker implementation.
     */
    public function add(CheckStatusInterface $service): void;

    /**
     * Iterate over all registered status checkers.
     *
     * @return iterable<CheckStatusInterface>
     */
    public function iterate(): iterable;
}

