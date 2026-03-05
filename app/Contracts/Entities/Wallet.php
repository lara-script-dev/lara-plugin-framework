<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Entities;

interface Wallet
{
    public function getAddress(): string;

    public function getMemo(): string;

    public function getHash(): string;
}

