<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Events;

use LaraPluginFramework\Contracts\Entities\AdminUser;
use LaraPluginFramework\Contracts\Entities\RequisiteVerification;
use LaraPluginFramework\Enums\VerificationStatusEnum;

interface RequisiteVerificationUpdatedEventInterface
{
    public function requisiteVerification(): RequisiteVerification;

    public function oldStatus(): VerificationStatusEnum;

    public function newStatus(): VerificationStatusEnum;

    public function author(): ?AdminUser;
}
