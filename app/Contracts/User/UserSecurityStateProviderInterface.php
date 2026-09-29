<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\User;

use DateTimeImmutable;

interface UserSecurityStateProviderInterface
{
    /** Null means that no security change has been recorded for this user. */
    public function lastChangedAt(UserInterface $user): ?DateTimeImmutable;

    /** Null means that the user has no verified email address. */
    public function verifiedEmail(UserInterface $user): ?string;
}
