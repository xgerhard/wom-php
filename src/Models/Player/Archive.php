<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;

class Archive extends BaseModel
{
    protected array $casts = [
        'player' => Player::class
    ];
}