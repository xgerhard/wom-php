<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;

class PlayerArchiveWithPlayer extends BaseModel
{
    protected array $casts = [
        'player' => Player::class
    ];
}