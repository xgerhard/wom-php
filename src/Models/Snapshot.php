<?php

namespace WOM\Models;

class Snapshot extends BaseModel
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