<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Events;

use LaraPluginFramework\Contracts\Entities\AdminUser;

interface AdminUserCreatedEvent
{
    public function adminUser(): AdminUser;
}
