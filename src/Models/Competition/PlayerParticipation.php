<?php

namespace WOM\Models\Competition;

use WOM\Models\BaseModel;
use WOM\Models\Player\Player;

class PlayerParticipation extends BaseModel
{
    protected array $casts = [
        'competition' => Competition::class,
        'player' => Player::class
    ];
}