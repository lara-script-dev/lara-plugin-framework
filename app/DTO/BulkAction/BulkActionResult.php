<?php

declare(strict_types=1);

namespace LaraPluginFramework\DTO\BulkAction;

/** @psalm-suppress PossiblyUnusedProperty — properties are consumed by plugins outside this package */
final class BulkActionResult
{
    /**
     * @param array<string, int> $details counters the confirmation dialog can show, e.g. created and updated
     */
    public function __construct(
        public readonly bool $success,
        public readonly int $affected = 0,
        public readonly ?string $message = null,
        public readonly ?string $error = null,
        public readonly array $details = [],
    ) {
    }

    /**
     * @param array<string, int> $details
     */
    public static function applied(int $affected, ?string $message = null, array $details = []): self
    {
        return new self(true, $affected, $message, null, $details);
    }

    /**
     * @param array<string, int> $details
     */
    public static function previewed(int $affected, array $details = []): self
    {
        return new self(true, $affected, null, null, $details);
    }

    public static function failed(string $error): self
    {
        return new self(false, 0, null, $error);
    }
}
