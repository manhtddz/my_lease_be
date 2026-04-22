<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRoleEnum;
use App\Models\Base\AdminAuthModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends AdminAuthModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $table = 'users';

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'manager_id',
        'department_id',
        'role',
        'del_flag',
    ];

    protected function password(): Attribute
    {
        return Attribute::make(
            set: fn($value) => genPassword($value)
        );
    }

    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'role' => UserRoleEnum::class,
    ];
}
