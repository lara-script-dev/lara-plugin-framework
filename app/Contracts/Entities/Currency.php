<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Entities;

interface Currency
{
    public function getId(): int;
    public function getName(?string $locale = null): string;
    public function getBaseCurrency(): string;
}
