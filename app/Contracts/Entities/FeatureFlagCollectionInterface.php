<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Entities;

use LaraPluginFramework\Enums\FeatureFlagEnum;

interface FeatureFlagCollectionInterface
{
    public function hasEnabled(FeatureFlagEnum $featureFlag): bool;
}
