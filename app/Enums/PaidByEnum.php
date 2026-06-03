<?php

namespace App\Enums;

final class PaidByEnum extends Enum
{
    const OWNER = 1;
    const TENANT = 2;

    public static function texts(): array
    {
        return [
            self::OWNER => 'OWNER',
            self::TENANT => 'TENANT',
        ];
    }
}
