<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Entities;

interface Rate
{
    public function getProvider(): string;

    public function getName(): string;

    public function getValue(): Decimal;
}

