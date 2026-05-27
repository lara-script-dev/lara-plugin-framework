<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Events;

/**
 * Dispatched after rates have been calculated for directions that plugins
 * declared as overridden (via `InterceptorTag::DIRECTION_RATE_OVERRIDE`).
 *
 * The payload is the union of overridden directions across all subscribed
 * plugins — each listener must filter it to its own directions before persisting.
 */
interface OverriddenDirectionRatesCalculatedEventInterface
{
    /**
     * @return list<array{direction_id: int, rate: string}>
     */
    public function directionRates(): array;
}
