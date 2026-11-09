<?php

declare(strict_types=1);

namespace LaraPluginFramework\DTO\TieredRate;

/**
 * One tier of a direction: a coefficient applied to the direction rate within [minAmount, maxAmount).
 * Amounts and the rate are decimal strings; a zero `maxAmount` means no upper bound.
 *
 * @psalm-suppress PossiblyUnusedProperty — properties are consumed by plugins outside this package
 */
final class TieredRate
{
    /**
     * @param int|null $id null for a tier that is not stored yet
     */
    public function __construct(
        public readonly ?int $id,
        public readonly string $minAmount,
        public readonly string $maxAmount,
        public readonly string $rate,
        public readonly bool $export,
    ) {
    }
}
