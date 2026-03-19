<?php

declare(strict_types=1);

namespace LaraPluginFramework\DTO;

/** @psalm-suppress PossiblyUnusedProperty — properties are consumed by plugins outside this package */
final class OrderRecalculationInterceptorResult
{
    public function __construct(
        public readonly string $outAmount,
        public readonly bool $modified = false,
    ) {
    }

    public static function unchanged(string $outAmount): self
    {
        return new self($outAmount);
    }
}
