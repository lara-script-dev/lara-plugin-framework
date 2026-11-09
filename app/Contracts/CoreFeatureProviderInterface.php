<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts;

use LaraPluginFramework\Enums\CoreFeatureEnum;

/**
 * Lets a plugin switch on core features that are off without it.
 *
 * Tag implementations under `CoreFeatureTag::PROVIDERS`.
 */
interface CoreFeatureProviderInterface
{
    /**
     * @return list<CoreFeatureEnum>
     */
    public function features(): array;
}
