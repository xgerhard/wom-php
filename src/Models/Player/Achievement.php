<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;

class Achievement extends BaseModel
{
    protected array $casts = [
        'player' => Player::class
    ];
}