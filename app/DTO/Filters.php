<?php

declare(strict_types=1);

namespace LaraPluginFramework\DTO;

use ArrayIterator;
use Countable;
use IteratorAggregate;
use LaraPluginFramework\Enums\FilterOperatorEnum;
use Traversable;

/**
 * @psalm-type FilterValue = scalar|array<array-key, mixed>|object|null
 * @psalm-type FilterPayload = array{
 *   by?: string,
 *   value?: FilterValue,
 *   operator?: FilterOperatorEnum|string
 * }
 * @implements IteratorAggregate<int, Filter>
 */
final class Filters implements Countable, IteratorAggregate
{
    /**
     * @param list<Filter> $filters
     */
    public function __construct(
        public readonly array $filters = [],
    ) {
    }

    /**
     * Build a filter collection from query params or already normalized filter payloads.
     *
     * @param array<array-key, Filter|FilterPayload|scalar|null> $filters
     */
    public static function fromArray(array $filters): self
    {
        $items = [];

        foreach ($filters as $key => $filter) {
            if ($filter instanceof Filter) {
                $items[] = $filter;
                continue;
            }

            if (is_array($filter)) {
                $normalized = self::normalizeFilterArray($key, $filter);

                if ($normalized !== null) {
                    $items[] = $normalized;
                }

                continue;
            }

            if (!is_string($key) || $key === '' || $filter === null || $filter === '') {
                continue;
            }

            $items[] = new Filter($key, $filter);
        }

        return new self($items);
    }

    /**
     * @return list<Filter>
     */
    public function all(): array
    {
        return $this->filters;
    }

    public function isEmpty(): bool
    {
        return $this->filters === [];
    }

    #[\Override]
    public function count(): int
    {
        return count($this->filters);
    }

    #[\Override]
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->filters);
    }

    /**
     * @param array-key $key
     * @param FilterPayload $filter
     */
    private static function normalizeFilterArray(int|string $key, array $filter): ?Filter
    {
        $by = $filter['by'] ?? (is_string($key) ? $key : null);
        $value = $filter['value'] ?? null;
        $rawOperator = $filter['operator'] ?? null;

        if (!is_string($by) || $by === '' || $value === null || $value === '') {
            return null;
        }

        $operator = $rawOperator instanceof FilterOperatorEnum
            ? $rawOperator
            : FilterOperatorEnum::tryFrom((string) $rawOperator) ?? FilterOperatorEnum::EQ;

        return new Filter($by, $value, $operator);
    }
}
