<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Entities;

use LaraPluginFramework\Enums\VerificationStatusEnum;

interface UserVerification
{
    public function getId(): int;

    public function getUserId(): int;

    public function getFirstName(): string;

    public function getLastName(): string;

    public function getStatus(): VerificationStatusEnum;

    public function getAdminComment(): ?string;
}
