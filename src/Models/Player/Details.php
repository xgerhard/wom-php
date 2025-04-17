<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;

class Details extends BaseModel
{
    protected array $casts = [
        'latestSnapshot' => Snapshot::class
    ];
}