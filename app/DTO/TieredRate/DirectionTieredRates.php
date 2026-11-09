<?php

declare(strict_types=1);

namespace LaraPluginFramework\DTO\TieredRate;

use LaraPluginFramework\Enums\TieredRateAmountSideEnum;

/**
 * Tiered rate settings of one direction, tiers sorted by `minAmount`.
 *
 * @psalm-suppress PossiblyUnusedProperty — properties are consumed by plugins outside this package
 */
final class DirectionTieredRates
{
    /**
     * @param bool $exportAsSteps export every tier as a `<step>` block in the rates file
     * @param list<TieredRate> $tiers
     */
    public function __construct(
        public readonly int $directionId,
        public readonly string $directionLabel,
        public readonly TieredRateAmountSideEnum $amountSide,
        public readonly bool $active,
        public readonly bool $exportAsSteps,
        public readonly array $tiers,
    ) {
    }
}
