<?php


namespace App\Models\Concerns;


use App\Enums\StateEnum;
use App\Models\Scopes\StateScope;

trait HasState
{

    static public string $stateField = 'state';

    use StateScope;

    public function isStateNew(): bool
    {
        return $this->{self::$stateField} == StateEnum::NEW;
    }

}
