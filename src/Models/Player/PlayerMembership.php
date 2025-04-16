<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;
use WOM\Models\Group\Group;

class PlayerMembership extends BaseModel
{
    protected array $casts = [
        'group' => Group::class
    ];
}