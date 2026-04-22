<?php

namespace App\Enums;

final class ApiStatusEnum extends Enum
{
    const SUCCESS = 0;
    const ERROR = 1;

    public static function texts(): array {
        return [
            self::SUCCESS => 'SUCCESS',
            self::ERROR => 'ERROR',
        ];
    }
}
