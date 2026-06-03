<?php

namespace App\Enums;

final class ActiveStatusEnum extends Enum
{
    const CANCELLED = 0;
    const ACTIVE = 1;

    public static function texts(): array
    {
        return [
            self::CANCELLED => 'CANCELLED',
            self::ACTIVE => 'ACTIVE',
        ];
    }
}
