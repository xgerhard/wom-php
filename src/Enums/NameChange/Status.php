<?php

namespace WOM\Enums\NameChange;

use WOM\Enums\BaseEnum;

class Status extends BaseEnum
{
    public const PENDING = 'pending';
    public const APPROVED = 'approved';
    public const DENIED = 'denied';
}
