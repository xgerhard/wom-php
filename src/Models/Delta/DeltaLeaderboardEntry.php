<?php

namespace WOM\Models\Delta;

use WOM\Models\BaseModel;
use WOM\Models\Player\Player;

class DeltaLeaderboardEntry extends BaseModel
{
    protected array $casts = [
        'player' => Player::class
    ];
}