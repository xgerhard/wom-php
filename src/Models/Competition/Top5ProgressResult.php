<?php

namespace WOM\Models\Competition;

use WOM\Models\BaseModel;
use WOM\Models\Player\Player;

class Top5ProgressResult extends BaseModel
{
    protected array $casts = [
        'player' => Player::class
    ];
}