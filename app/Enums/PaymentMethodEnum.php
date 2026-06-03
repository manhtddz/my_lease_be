<?php

namespace App\Enums;

final class PaymentMethodEnum extends Enum
{
    const BANKING = 1;
    const CASH = 2;

    public static function texts(): array
    {
        return [
            self::BANKING => 'BANKING',
            self::CASH => 'CASH',
        ];
    }
}
