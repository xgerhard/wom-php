<?php

namespace WOM\Models\NameChange;

use WOM\Models\BaseModel;
use WOM\Models\Player\Player;

class NameChange extends BaseModel
{
    protected array $casts = [
        'player' => Player::class
    ];
}