<?php

namespace LaraPluginFramework\Enums;

enum OrderStatusEnum: int
{
    case CREATED_STATUS = 0;
    case USER_APPROVED_STATUS = 1;
    case WAITING_STATUS = 2;
    case PAID_STATUS = 3;
    case DELETED_STATUS = 4;
    case ERROR_STATUS = 5;
    case CHECK_STATUS = 6;
    case CANCELLED_STATUS = 7;
    case COMPLETED_STATUS = 8;
    case WAITING_AUTO_WITHDRAWS_STATUS = 9;
    case ERROR_AUTO_WITHDRAWS_STATUS = 10;
    case AML_CHECK_STATUS = 11;
    case PARTIALLY_PROCESSED_AUTO_WITHDRAWS_STATUS = 12;
}
