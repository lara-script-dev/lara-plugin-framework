<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Entities;

interface Decimal
{
    public function getPrecision(): int;

    public function withMaxPrecision(): self;

    public function withPrecision(int $precision): self;

    public function getValue(): string;

    public function round(int $precision): string;

    public function add(self $value): self;

    public function sub(self $value): self;

    public function multiply(self $value): self;

    public function divide(self $value): self;

    public function divideRounded(self $value): self;

    public function min(self ...$decimals): self;

    public function max(self ...$decimals): self;

    public function less(self $decimal): bool;

    public function lessOrEqual(self $decimal): bool;

    public function greater(self $decimal): bool;

    public function greaterOrEqual(self $decimal): bool;

    public function equals(self $decimal): bool;

    public function percent(self $percent): self;

    public function shortened(): string;

    public function isZero(): bool;

    public function isNotZero(): bool;

    /**
     * @return array{value: string, precision: int}
     */
    public function jsonSerialize(): array;

    public function trimTrailingZeros(): string;

    public function __toString(): string;

    public function ceil(int $precision = 0): self;

    public function getIntegerDigitsCount(): int;

    public function getDecimalDigitsCount(): int;

    public function getTotalDigitsCount(): int;

    public function fitsInDecimal(int $precision, int $scale): bool;

    /**
     * @return array{value: string, precision: int}
     */
    public function __serialize(): array;

    /**
     * @param array{value: string, precision: int} $data
     */
    public function __unserialize(array $data): void;
}
