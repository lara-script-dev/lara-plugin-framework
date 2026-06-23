<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Entities;

interface City
{
    public function getId(): int;

    public function getCode(): string;

    public function getName(?string $locale = null): string;

    public function isEnabled(): bool;
}
