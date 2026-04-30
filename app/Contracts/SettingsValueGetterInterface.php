<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts;

/**
 * Returns stored settings so that Lara Script can pre-fill UI forms.
 */
interface SettingsValueGetterInterface
{
    /**
     * Implementations may read query params from the current Illuminate HTTP request.
     *
     * @return array<string, mixed> Persisted settings for the requested context.
     */
    public function get(): array;
}
