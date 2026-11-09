<?php

declare(strict_types=1);

namespace LaraPluginFramework\Enums;

/**
 * Core features that stay off until an active plugin provides them.
 */
enum CoreFeatureEnum: string
{
    case TIERED_RATES = 'tiered_rates';
}
