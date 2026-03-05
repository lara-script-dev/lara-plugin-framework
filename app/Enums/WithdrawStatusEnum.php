<?php

declare(strict_types=1);

namespace LaraPluginFramework\Enums;

enum WithdrawStatusEnum: int
{
    case CREATED = 0;
    case PAID = 1;
    case CANCELLED = 2;
    case CANCELLED_BY_USER = 3;
}
