<?php

namespace App\Enums;

final class DebtTypeEnum extends Enum
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
