<?php


namespace App\Models\Concerns;


use App\Enums\AuthRoleEnum;
use App\Models\Scopes\RoleScope;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasRole
{

    static public string $roleField = 'role';
    static public string $expireTrialDateField = 'expire_trial_date';

    use RoleScope;


    public function isRoleAdmin(): bool
    {
        $roleValue = $this->getAttributes()[self::$roleField];
        return $roleValue == AuthRoleEnum::ADMIN;
    }

    public function isRoleTrial(): bool
    {
        $roleValue = $this->getAttributes()[self::$roleField];
        return $roleValue == AuthRoleEnum::TRIAL;
    }

    public function isRoleMember(): bool
    {
        $roleValue = $this->getAttributes()[self::$roleField];
        return $roleValue == AuthRoleEnum::MEMBER;
    }

    protected function role(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => array(
                'value' => $value,
                'text' => AuthRoleEnum::getDescription($value),
                'isRoleAdmin' => $this->isRoleAdmin(),
                'isRoleTrial' => $this->isRoleTrial(),
                'isRoleMember' => $this->isRoleMember(),
            ),
            set: fn($value) => $value
        );
    }

    protected function expireTrialDate(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => array(
                    'value' => $value ? cFormat('Y-m-d', $value) : null,
                    'expired' => $value ? cParse($value)->isPast() : false
                )
        );
    }

    public function isTrialDateExpired(): bool
    {
        $expireTrialDate = $this->{self::$expireTrialDateField};
        return data_get($expireTrialDate, 'expired', false);
    }

    public function isUserTrialExpired(): bool
    {
        return $this->isRoleTrial() && $this->isTrialDateExpired();
    }


}
