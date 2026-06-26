<?php

namespace App\Enums;

final class ItemTypeEnum extends Enum
{
    const ELECTRICITY = 1;
    const WATER = 2;
    const OCCUPIED = 3;
    const DEBT = 4;
    const RENOVATION = 5;

    public static function texts(): array {
        return [
            self::ELECTRICITY => 'ELECTRICITY',
            self::WATER => 'WATER',
            self::OCCUPIED => 'OCCUPIED',
            self::DEBT => 'DEBT',
            self::RENOVATION => 'RENOVATION',
        ];
    }
}
