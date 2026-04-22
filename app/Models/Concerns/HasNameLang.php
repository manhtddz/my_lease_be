<?php

namespace App\Models\Concerns;

use App\Enums\LanguageEnum;
use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasNameLang
{
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->getRawOriginal($this->getCurrentLangName()),
        );
    }

    public static function getCurrentLangName(string $column = 'name'): string
    {
        if (getCurrentLangCode() != LanguageEnum::JA) {
            $column = $column . '_' . getCurrentLangCode();
        }
        return $column;
    }
}
