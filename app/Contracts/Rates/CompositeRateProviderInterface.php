<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Rates;

interface CompositeRateProviderInterface extends RateProviderInterface
{
    public function add(RateProviderInterface $provider): void;
}

