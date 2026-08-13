<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\User;

interface UserInterface
{
    public function getId(): int;

    public function getEmail(): string;

    public function getLanguageCode(): string;
}
