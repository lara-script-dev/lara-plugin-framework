<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts;

/**
 * Persists plugin settings received from Lara Script administrators.
 */
interface SettingsSaverInterface
{
    /**
     * @param array<string, mixed> $settings Arbitrary plugin settings to save.
     * @return array<string, mixed> Data that describes the result of the save operation.
     */
    public function save(array $settings): array;
}
