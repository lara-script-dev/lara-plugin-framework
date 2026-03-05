<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Entities;

use LaraPluginFramework\Enums\VerificationStatusEnum;

interface RequisiteVerification
{
    public function getId(): int;

    public function getRequisiteId(): int;

    public function getStatus(): VerificationStatusEnum;

    public function getAdminComment(): ?string;
}
