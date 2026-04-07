<?php

declare(strict_types=1);

namespace LaraPluginFramework\DTO;

/** @psalm-suppress PossiblyUnusedProperty — properties are consumed by plugins outside this package */
final class OrderCreationInterceptorResult
{
    /**
     * @param array<string, mixed> $metadata Key-value pairs to store on the order
     */
    public function __construct(
        public readonly string $inAmount,
        public readonly string $outAmount,
        public readonly array $metadata = [],
        public readonly bool $modified = false,
    ) {
    }

    public static function unchanged(string $inAmount, string $outAmount): self
    {
        return new self($inAmount, $outAmount);
    }
}
