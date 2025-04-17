<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;

class Gains extends BaseModel
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