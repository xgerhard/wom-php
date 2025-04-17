<?php

namespace WOM\Models\Group;

use WOM\Models\BaseModel;

class PlayerMembership extends BaseModel
{
    protected array $casts = [
        'group' => Group::class
    ];
}