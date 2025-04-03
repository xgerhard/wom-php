<?php

namespace WOM\Models;

class Player extends BaseModel
{
    protected array $casts = [
        'player' => Player::class,
        'latestSnapshot' => Snapshot::class,
        'snapshots' => [
            'type' => Snapshot::class,
            'many' => true
        ],
    ];
}