<?php

namespace WOM\Models\Group;

use WOM\Models\BaseModel;

class Details extends BaseModel
{
    protected array $casts = [
        'memberships' => [
            'type' => Membership::class,
            'many' => true
        ]
    ];
}