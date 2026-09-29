<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Events;

use DateTimeImmutable;

interface UserPasswordChangedEventInterface
{
    public function userId(): int;

    public function changedAt(): DateTimeImmutable;
}
