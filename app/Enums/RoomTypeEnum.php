<?php

namespace App\Enums;

final class RoomTypeEnum extends Enum
{
    const SINGLE = 1;
    const DOUBLE = 2;
    const TRIPLE = 3;
    const QUADRUPLE = 4;
    const FAMILY = 5;

    public static function texts(): array {
        return [
            self::SINGLE => 'SINGLE',
            self::DOUBLE => 'DOUBLE',
            self::TRIPLE => 'TRIPLE',
            self::QUADRUPLE => 'QUADRUPLE',
            self::FAMILY => 'FAMILY',
        ];
    }
}
