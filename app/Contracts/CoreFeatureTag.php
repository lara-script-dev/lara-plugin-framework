<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts;

/**
 * Service container tag for core feature providers.
 *
 * The core collects every `CoreFeatureProviderInterface` tagged here; a feature
 * is enabled while at least one active plugin returns it.
 */
final class CoreFeatureTag
{
    public const PROVIDERS = 'core_feature_providers';
}
