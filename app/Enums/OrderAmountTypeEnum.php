<?php

declare(strict_types=1);

namespace LaraPluginFramework\Enums;

enum OrderAmountTypeEnum: string
{
    case IN = 'in';
    case OUT = 'out';
    case PAID = 'paid';
}
