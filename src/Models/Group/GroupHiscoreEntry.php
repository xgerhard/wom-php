<?php

namespace WOM\Models\Group;

use WOM\Models\BaseModel;
use WOM\Models\Player\Player;

class GroupHiscoreEntry extends BaseModel
{
    protected array $casts = [
        'player' => Player::class
    ];
}