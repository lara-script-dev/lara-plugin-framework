<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Events;

use LaraPluginFramework\Contracts\Entities\AdminUser;

interface AdminUserDeletedEvent
{
    public function adminUser(): AdminUser;
}
