<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait PropertyConcern
{
    protected function buildingAreaMeters(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => removeTrailingZeros($value),
        );
    }

    protected function buildingAreaTsubo(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => removeTrailingZeros($value),
        );
    }

}
