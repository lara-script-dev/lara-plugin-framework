<?php

declare(strict_types=1);

namespace LaraPluginFramework\DTO\TieredRate;

use LaraPluginFramework\Enums\TieredRateAmountSideEnum;

/**
 * Changes to the tiered rate settings of one direction; a null field is left unchanged.
 *
 * @psalm-suppress PossiblyUnusedProperty — properties are consumed by plugins outside this package
 */
final class DirectionTieredRatesChange
{
    /**
     * @param list<TieredRate>|null $tiers replaces the whole set of tiers; tier ids are ignored
     */
    public function __construct(
        public readonly ?TieredRateAmountSideEnum $amountSide = null,
        public readonly ?bool $active = null,
        public readonly ?bool $exportAsSteps = null,
        public readonly ?array $tiers = null,
    ) {
    }
}
