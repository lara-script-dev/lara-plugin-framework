<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Repository;

use LaraPluginFramework\Contracts\Entities\FeatureFlagCollectionInterface;

interface FeatureFlagRepositoryInterface
{
    public function get(): FeatureFlagCollectionInterface;
}
