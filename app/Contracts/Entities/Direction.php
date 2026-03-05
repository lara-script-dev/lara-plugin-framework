<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Entities;

interface Direction
{
    public function getId(): int;

    public function getFromCurrencyId(): int;

    public function getToCurrencyId(): int;

    public function getQuoteId(): int;

    public function isEnabled(): bool;

    public function getPriority(): int;

    public function getPercent(): Decimal;

    public function getMinAmount(): ?Decimal;

    public function getMaxAmount(): ?Decimal;

    public function isUserVerificationRequired(): bool;
}
