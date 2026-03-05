<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts;

use LaraPluginFramework\Contracts\Entities\AdminUser;

interface AdminUserGetterInterface
{
    public function getAdminUser(): AdminUser;
}
