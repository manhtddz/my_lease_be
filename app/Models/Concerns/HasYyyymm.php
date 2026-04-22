<?php

namespace App\Models\Concerns;


use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasYyyymm
{
    protected function yyyymm(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => convertNumberToYYYYMM($value),
            set: fn ($value) => convertYYYYMMToNumber($value),
        );
    }
}
