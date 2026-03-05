<?php

declare(strict_types=1);

namespace LaraPluginFramework\Enums;

enum VirtualBalanceChangeTypeEnum: int
{
    case SYSTEM = 0;
    case MANUAL = 1;
    case ORDER_PROFIT = 2;
}
