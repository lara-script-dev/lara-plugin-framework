<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Currency;

use LaraPluginFramework\Contracts\Currency\DTO\CreateCurrencyDTOInterface;
use LaraPluginFramework\Contracts\Entities\Currency;

interface CreatorInterface
{
    public function create(CreateCurrencyDTOInterface $dto): Currency;
}
