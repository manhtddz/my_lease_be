<?php

namespace Core\Traits;

/**
 * https://www.php.net/manual/en/language.enumerations.examples.php
 */
trait HasEnumLabel
{
    /**
     * ClassName::CONSTANT_NAME->label()
     *
     * @return string
     */
    abstract public function label(): string;

    /**
     * @param string $label
     * @return mixed
     */
    public static function fromLabel(string $label): mixed
    {
        return collect(self::cases())->first(function (self $enum) use ($label) {
            return $enum->label() === $label;
        });
    }

    /**
     * @return array
     */
    public static function values(): array
    {
        return array_map(fn($enum) => $enum->value, static::cases());
    }

    /**
     * @return array
     */
    public static function names(): array
    {
        return array_map(fn($enum) => $enum->name, static::cases());
    }

    /**
     * @return array
     */
    public static function forSelect()
    {
        return array_combine(static::values(), static::names());
    }
}
