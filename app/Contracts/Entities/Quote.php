<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Entities;

interface Quote
{
    public function id(): int;

    public function formula(): string;

    public function groupId(): int;
}
