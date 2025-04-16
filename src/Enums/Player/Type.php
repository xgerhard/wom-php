<?php

namespace WOM\Enums\Player;

use WOM\Enums\BaseEnum;

class Type extends BaseEnum
{
    public const UNKNOWN = 'unknown';
    public const REGULAR = 'regular';
    public const IRONMAN = 'ironman';
    public const HARDCORE = 'hardcore';
    public const ULTIMATE = 'ultimate';
}