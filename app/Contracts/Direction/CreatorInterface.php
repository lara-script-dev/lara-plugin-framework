<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Direction;

use LaraPluginFramework\Contracts\Direction\DTO\CreateDirectionDTOInterface;
use LaraPluginFramework\Contracts\Entities\Direction;

interface CreatorInterface
{
    public function create(CreateDirectionDTOInterface $dto): Direction;
}
