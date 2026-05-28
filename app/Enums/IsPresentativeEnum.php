<?php

namespace App\Enums;

final class IsPresentativeEnum extends Enum
{
    const FALSE = 0;
    const TRUE = 1;

    public static function texts(): array {
        return [
            self::FALSE => 'FALSE',
            self::TRUE => 'TRUE',
        ];
    }
}
