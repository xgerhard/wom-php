<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;
use WOM\Models\Traits\HasRank;
use WOM\Models\Traits\HasMetric;

class Metric extends BaseModel
{
    use HasRank, HasMetric;

    protected array $casts = [
        'player' => Player::class
    ];

    public function formatValue(): string
    {
        return round($this->value);
    }
}