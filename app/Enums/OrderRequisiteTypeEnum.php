<?php

declare(strict_types=1);

namespace LaraPluginFramework\Enums;

enum OrderRequisiteTypeEnum: string
{
    case OUT = 'out';
    case OUT_MEMO = 'out_memo';
    case IN = 'in';
}
