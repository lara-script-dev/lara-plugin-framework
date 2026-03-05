<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts;

/**
 * Returns stored settings so that Lara Script can pre-fill UI forms.
 */
interface SettingsValueGetterInterface
{
    /**
     * @return array<string, mixed> Persisted settings for the requested context.
     */
    public function get(): array;
}
