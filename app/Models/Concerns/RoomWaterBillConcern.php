<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait RoomWaterBillConcern
{

    protected function tenantMeter(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => removeTrailingZeros($value),
        );
    }

    protected function ownerMeter(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => removeTrailingZeros($value),
        );
    }

    protected function tenantCubicMeter(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => removeTrailingZeros($value),
        );
    }

    protected function ownerCubicMeter(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => removeTrailingZeros($value),
        );
    }

    protected function supplierId1Meter(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => removeTrailingZeros($value),
        );
    }

    protected function supplierId2Meter(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => removeTrailingZeros($value),
        );
    }

    protected function supplierId3Meter(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => removeTrailingZeros($value),
        );
    }

    protected function supplierId4Meter(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => removeTrailingZeros($value),
        );
    }

    protected function supplierId5Meter(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => removeTrailingZeros($value),
        );
    }

    protected function supplierId1M3(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => removeTrailingZeros($value),
        );
    }

    protected function supplierId2M3(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => removeTrailingZeros($value),
        );
    }

    protected function supplierId3M3(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => removeTrailingZeros($value),
        );
    }

    protected function supplierId4M3(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => removeTrailingZeros($value),
        );
    }

    protected function supplierId5M3(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => removeTrailingZeros($value),
        );
    }
}
