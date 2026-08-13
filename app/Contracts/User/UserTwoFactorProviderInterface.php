<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\User;

interface UserTwoFactorProviderInterface
{
    public function isEmailEnabled(UserInterface $user): bool;

    public function isTotpEnabled(UserInterface $user): bool;

    public function verifyTotp(UserInterface $user, string $code): bool;
}
