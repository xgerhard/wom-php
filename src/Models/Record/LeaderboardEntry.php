<?php

namespace WOM\Models\Record;

use WOM\Models\BaseModel;
use WOM\Models\Player\Player;
use WOM\Models\Traits\HasMetric;

class LeaderboardEntry extends BaseModel
{
    use HasMetric;

    protected array $casts = [
        'player' => Player::class
    ];
}