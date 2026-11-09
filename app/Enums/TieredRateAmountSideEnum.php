<?php

declare(strict_types=1);

namespace LaraPluginFramework\Enums;

/**
 * Side of the exchange the tier bounds (`min_amount`, `max_amount`) are expressed in.
 */
enum TieredRateAmountSideEnum: string
{
    case GIVE = 'give';
    case RECEIVE = 'receive';
}
