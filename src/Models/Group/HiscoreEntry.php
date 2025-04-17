<?php

namespace WOM\Models\Group;

use WOM\Models\BaseModel;
use WOM\Models\Player\Player;

class HiscoreEntry extends BaseModel
{
    protected array $casts = [
        'player' => Player::class
    ];
}