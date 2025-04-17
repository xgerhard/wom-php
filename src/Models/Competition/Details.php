<?php

namespace WOM\Models\Competition;

use WOM\Models\BaseModel;
use WOM\Models\Group\Group;
use WOM\Models\Competition\PlayerParticipation;

class Details extends BaseModel
{
    protected array $casts = [
        'group' => Group::class,
        'participations' => [
            'type' => PlayerParticipation::class,
            'many' => true
        ]
    ];
}