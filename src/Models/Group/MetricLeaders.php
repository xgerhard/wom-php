<?php

namespace WOM\Models\Group;

use WOM\Models\BaseModel;
use WOM\Models\Player\Activity;
use WOM\Models\Player\Boss;
use WOM\Models\Player\Metric;
use WOM\Models\Player\Skill;
use WOM\Models\Player\Snapshot;

/**
 * @property object $skills
 * @property object $bosses
 * @property object $activities
 * @property object $computed
 */
class MetricLeaders extends BaseModel
{
    protected array $casts = [
        'skills' => [
            'type' => Skill::class,
            'many' => true
        ],
        'bosses' => [
            'type' => Boss::class,
            'many' => true
        ],
        'activities' => [
            'type' => Activity::class,
            'many' => true
        ],
        'computed' => [
            'type' => Metric::class,
            'many' => true
        ],
    ];
}