<?php

namespace App\Models\Concerns;

use App\Enums\BankAccountTypeEnum;

trait OwnerConcern
{
    public static function combineNameWithKana(string $name, string|null $nameKana = null): string
    {
        $combineText = $name;
        if ($nameKana) {
            $combineText .= '（' . $nameKana . '）';
        }
        return $combineText;
    }

    public static function concatSymbolWithZipCode(string|null $zipCode = null): string|null
    {
        $zipCodeSymbol = trans2('zip_code');
        if ($zipCode) {
            return $zipCodeSymbol . $zipCode;
        }
        return $zipCode;

    }

    public static function getBankAccountTypeText($bankType)
    {
        $text = '';
        if ($bankType && in_array($bankType, BankAccountTypeEnum::getValues())) {
            $text = BankAccountTypeEnum::texts()[$bankType];
        };
        return $text;
    }

}
