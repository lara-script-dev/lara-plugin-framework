<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Entities;

interface AdminUser
{
    public function getId(): int;
    public function getLanguageCode(): string;
    public function getName(): string;
}
