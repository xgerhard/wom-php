<?php

namespace WOM\Models\Group;

use WOM\Models\BaseModel;
use WOM\Models\Group\GroupMembership;

class GroupDetails extends BaseModel
{
    protected array $casts = [
        'memberships' => [
            'type' => GroupMembership::class,
            'many' => true
        ]
    ];
}