<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Direction\Service;

/**
 * Lets a plugin declare which directions it manages externally,
 * so the core skips writing `directions.rate` for them.
 *
 * The core calls every implementation tagged under
 * `InterceptorTag::DIRECTION_RATE_OVERRIDE` and merges the returned IDs.
 */
interface DirectionRateOverrideInterceptorInterface
{
    /**
     * @return list<int> Direction IDs that the plugin manages — core must not overwrite their `rate`.
     */
    public function getOverriddenDirectionIds(): array;
}
