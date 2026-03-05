<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts;

/**
 * Each plugin must expose one provider that lists concrete implementations for Lara Script.
 */
interface PluginServiceProviderInterface
{
    /**
     * @return array<class-string, class-string> Map of contract => concrete implementation FQCN.
     */
    public function implementations(): array;
}
