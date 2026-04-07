<?php

declare(strict_types=1);

namespace LaraPluginFramework\Contracts\Direction\Service;

use LaraPluginFramework\Contracts\Entities\Direction;

interface DirectionResponseEnricherInterface
{
    /**
     * @return array<string, mixed>
     */
    public function enrich(Direction $direction): array;
}
