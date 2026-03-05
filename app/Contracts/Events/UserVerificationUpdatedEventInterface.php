<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Events;

use LaraPluginFramework\Contracts\Entities\AdminUser;
use LaraPluginFramework\Contracts\Entities\UserVerification;
use LaraPluginFramework\Enums\VerificationStatusEnum;

interface UserVerificationUpdatedEventInterface
{
    public function userVerification(): UserVerification;

    public function oldStatus(): VerificationStatusEnum;

    public function newStatus(): VerificationStatusEnum;

    public function author(): ?AdminUser;
}
