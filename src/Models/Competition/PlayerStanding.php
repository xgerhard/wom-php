<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;
use WOM\Models\Competition\Competition;

class PlayerStanding extends BaseModel
{
    protected array $casts = [
        'competition' => Competition::class
    ];
}