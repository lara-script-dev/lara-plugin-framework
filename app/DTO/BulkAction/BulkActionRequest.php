<?php

declare(strict_types=1);

namespace LaraPluginFramework\DTO\BulkAction;

use LaraPluginFramework\DTO\Filters;
use LaraPluginFramework\Enums\BulkActionType;

/** @psalm-suppress PossiblyUnusedProperty — properties are consumed by plugins outside this package */
final class BulkActionRequest
{
    /**
     * @param array<string, mixed> $values
     */
    public function __construct(
        public readonly string $tab,
        public readonly BulkActionType $action,
        public readonly Filters $filters,
        public readonly array $values = [],
        public readonly bool $preview = false,
    ) {
    }
}
