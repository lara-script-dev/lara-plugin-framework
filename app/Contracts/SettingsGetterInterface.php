<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts;

/**
 * Provides serialized settings (JSON) that will be shown in Lara Script UI.
 */
interface SettingsGetterInterface
{
    /**
     * @return non-empty-string JSON encoded payload with plugin settings metadata.
     */
    public function get(): string;
}
