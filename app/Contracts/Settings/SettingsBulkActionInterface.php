<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Settings;

use LaraPluginFramework\DTO\BulkAction\BulkActionRequest;
use LaraPluginFramework\DTO\BulkAction\BulkActionResult;

interface SettingsBulkActionInterface
{
    /**
     * Settings tabs this handler serves.
     *
     * @return list<string>
     */
    public function tabs(): array;

    public function apply(BulkActionRequest $request): BulkActionResult;
}
