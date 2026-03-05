<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Context;

interface Context
{
    /**
     * Raw payload of the incoming notification.
     *
     * @return array<string, mixed>
     */
    public function getData(): array;
}

