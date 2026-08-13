<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\User;

interface UserProviderInterface
{
    public function getAuthenticatedUser(): ?UserInterface;

    public function findById(int $id): ?UserInterface;
}
