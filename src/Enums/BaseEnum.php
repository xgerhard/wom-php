<?php

namespace WOM\Enums;

use ReflectionClass;

abstract class BaseEnum
{
    public static function all(): array
    {
        return array_values((new ReflectionClass(static::class))->getConstants());
    }

    public static function label(string $value): string
    {
        return ucwords(str_replace('_', ' ', $value));
    }

    public static function labels(): array
    {
        $constants = (new ReflectionClass(static::class))->getConstants();

        return array_map(
            fn($value) => static::label($value),
            $constants
        );
    }
}
