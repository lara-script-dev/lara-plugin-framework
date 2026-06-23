<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Entities;

interface DirectionCity
{
    public function getDirectionId(): int;

    public function getCityId(): int;

    public function getCity(): City;

    public function getCoefficient(): Decimal;

    public function getFixedRate(): ?Decimal;

    public function getEffectiveRate(): Decimal;

    public function getMinAmount(): Decimal;
}
