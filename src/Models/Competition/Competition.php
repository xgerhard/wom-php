<?php

namespace WOM\Models\Competition;

use WOM\Models\BaseModel;
use WOM\Models\Group\Group;
use WOM\Models\Traits\HasMetric;

class Competition extends BaseModel
{
    use HasMetric;

    protected array $casts = [
        'group' => Group::class,
        'competition' => Competition::class,
        'participations' => [
            'type' => PlayerParticipation::class,
            'many' => true
        ]
    ];
}