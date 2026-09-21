<?php

declare(strict_types=1);

namespace LaraPluginFramework\Enums;

enum BulkActionType: string
{
    case ADD = 'add';
    case UPDATE = 'update';
    case DELETE = 'delete';
    case COPY = 'copy';
}
