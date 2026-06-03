<?php

namespace App\Enums;

final class RoomStatusEnum extends Enum
{
    const AVAILABLE = 0;
    const PARTIALLY_OCCUPIED = 1;
    const FULLY_OCCUPIED = 2;
    const RESERVED = 3;

    public static function texts(): array
    {
        return [
            self::AVAILABLE => 'AVAILABLE',
            self::PARTIALLY_OCCUPIED => 'PARTIALLY_OCCUPIED',
            self::FULLY_OCCUPIED => 'FULLY_OCCUPIED',
            self::RESERVED => 'RESERVED',
        ];
    }
}
