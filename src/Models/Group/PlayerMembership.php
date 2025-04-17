<?php

namespace WOM\Models\Group;

use WOM\Models\BaseModel;
use WOM\Models\Group\Group;

class PlayerMembership extends BaseModel
{
    protected array $casts = [
        'group' => Group::class
    ];
}