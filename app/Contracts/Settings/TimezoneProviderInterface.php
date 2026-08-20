<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Settings;

interface TimezoneProviderInterface
{
    /** Returns the configured IANA timezone identifier for the current Lara installation. */
    public function getTimezone(): string;
}
