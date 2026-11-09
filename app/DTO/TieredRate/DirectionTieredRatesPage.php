<?php

declare(strict_types=1);

namespace LaraPluginFramework\DTO\TieredRate;

/** @psalm-suppress PossiblyUnusedProperty — properties are consumed by plugins outside this package */
final class DirectionTieredRatesPage
{
    /**
     * @param list<DirectionTieredRates> $items
     */
    public function __construct(
        public readonly array $items,
        public readonly int $lastPage,
    ) {
    }
}
