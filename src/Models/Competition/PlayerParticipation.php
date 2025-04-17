<?php

namespace WOM\Models\Competition;

use WOM\Models\BaseModel;

class PlayerParticipation extends BaseModel
{
    protected array $casts = [
        'competition' => Competition::class
    ];
}