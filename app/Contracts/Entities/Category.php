<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Entities;

interface Category
{
    public function getId(): int;

    public function getName(): string;

    public function getPriority(): int;
}

