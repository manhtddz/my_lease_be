<?php

namespace App\Enums;

final class UserRoleEnum extends Enum
{
    const ADMIN = 1;
    const MANAGER = 2;
    const EMPLOYEE = 3;

    public static function texts(): array {
        return [
            self::ADMIN => 'ADMIN',
            self::MANAGER => 'MANAGER',
            self::EMPLOYEE => 'EMPLOYEE',
        ];
    }
}
