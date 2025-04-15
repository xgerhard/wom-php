<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;

class PlayerDetails extends BaseModel
{
    protected array $casts = [
        'latestSnapshot' => Snapshot::class
    ];
}