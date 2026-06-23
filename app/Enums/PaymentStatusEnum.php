<?php

namespace App\Enums;

final class PaymentStatusEnum extends Enum
{
    const INITIAL = 1;
    const PAID = 2;
    const PARTIALLY_PAID = 3;
    const NOT_PAID_OVERDUE = 4;

    public static function texts(): array
    {
        return [
            self::INITIAL => 'INITIAL',
            self::PAID => 'PAID',
            self::PARTIALLY_PAID => 'PARTIALLY_PAID',
            self::NOT_PAID_OVERDUE => 'NOT_PAID_OVERDUE',
        ];
    }
    
    public static function getUnpaidStatus()
    {
        return [
            self::INITIAL,
            self::PARTIALLY_PAID,
        ];
    }
}
