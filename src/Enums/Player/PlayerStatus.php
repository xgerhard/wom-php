<?php

namespace WOM\Enums\Player;

use WOM\Enums\BaseEnum;

class PlayerStatus extends BaseEnum
{
    public const ACTIVE = 'active';
    public const UNRANKED = 'unranked';
    public const FLAGGED = 'flagged';
    public const ARCHIVED = 'archived';
    public const BANNED = 'banned';
}