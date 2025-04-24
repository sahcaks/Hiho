<?php

namespace app\helper\Enum;
interface TableStatusEnum
{
    public const int OPEN = 0;
    public const int PENDING = 1;
    public const int RESERVED = 2;
    public const array STATUS_LIST = [
        self::OPEN => 'Open',
        self::PENDING => 'Pending',
        self::RESERVED => 'Reserved',
    ];
}