<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;

/**
 * @property object $skills
 * @property object $bosses
 * @property object $activities
 * @property object $computed
 */
class SnapshotData extends BaseModel
{
    protected array $casts = [
        'skills' => [
            'type' => Skill::class,
            'many' => true,
        ],
        'bosses' => [
            'type' => Boss::class,
            'many' => true,
        ],
        'activities' => [
            'type' => Activity::class,
            'many' => true,
        ],
        'computed' => [
            'type' => Metric::class,
            'many' => true,
        ],
    ];
}
