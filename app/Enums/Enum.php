<?php
namespace App\Enums;

use BenSampo\Enum\Contracts\LocalizedEnum;
use BenSampo\Enum\Enum as BenSampoEnum;

abstract class Enum extends BenSampoEnum implements LocalizedEnum
{
    public string $text;

    /**
     * @param mixed $enumValue
     * @throws \BenSampo\Enum\Exceptions\InvalidEnumMemberException
     */
    public function __construct(mixed $enumValue)
    {
        parent::__construct($enumValue);
        $this->text = data_get(static::texts(), $enumValue, '');
    }

    public function getText(): string
    {
        return $this->text;
    }


    abstract public static function texts(): array;


    public static function dropdown(bool|array $defaultOptions = [], string $sort = ''): array
    {
        $options = static::texts();

        if (is_array($defaultOptions)) {
            $options = $defaultOptions + $options;
        }

        if ($sort == 'asc') {
            ksort($options);
        } elseif ($sort == 'desc') {
            krsort($options);
        }

        if ($defaultOptions === true && !isset($options[''])) {
            $options = ['' => trans2('select_default')] + $options;
        }

        return $options;
    }

}
