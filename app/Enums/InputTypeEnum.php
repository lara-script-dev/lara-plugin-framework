<?php

declare(strict_types=1);

namespace LaraPluginFramework\Enums;

enum InputTypeEnum: string
{
    case TEXT = 'text';
    case PASSWORD = 'password';
    case EMAIL = 'email';
    case SELECT = 'select';
    case TIME = 'time';
}

