<?php

namespace WOM\Enums\Competition;

use WOM\Enums\BaseEnum;

class Status extends BaseEnum
{
    public const PENDING = 'upcoming';
    public const ONGOING = 'ongoing';
    public const FINISHED = 'finished';
}
