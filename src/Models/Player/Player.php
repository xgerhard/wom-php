<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;

class Player extends BaseModel
{
    protected array $casts = [
        'player' => Player::class
    ];
}