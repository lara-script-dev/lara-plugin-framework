<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Events;

use DateTimeImmutable;

interface User2FaChangedEventInterface
{
    public function userId(): int;

    public function changedAt(): DateTimeImmutable;

    /** EMAIL or TOTP. */
    public function method(): string;

    /** ENABLED or DISABLED. */
    public function action(): string;
}
