<?php

declare(strict_types=1);

namespace LaraPluginFramework\DTO;

use LaraPluginFramework\Enums\FilterOperatorEnum;

/** @psalm-suppress PossiblyUnusedProperty — properties are consumed by plugins outside this package */
final class Filter
{
    /**
     * @param non-empty-string $by
     */
    public function __construct(
        public readonly string $by,
        public readonly mixed $value,
        public readonly FilterOperatorEnum $operator = FilterOperatorEnum::EQ,
    ) {
    }
}
