<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Organization;

/**
 * Provides the external organization UID assigned to this Lara installation.
 */
interface OrganizationOasisUidProviderInterface
{
    public function getOrganizationUid(): string;
}
