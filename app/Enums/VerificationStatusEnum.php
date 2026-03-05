<?php

declare(strict_types=1);

namespace LaraPluginFramework\Enums;

enum VerificationStatusEnum: int
{
    case IN_PROGRESS = 1;
    case NON_VERIFIED = 2;
    case DECLINED = 3;
    case APPROVED = 4;
}
