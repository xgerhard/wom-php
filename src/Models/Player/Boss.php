<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;
use WOM\Models\Traits\HasRank;
use WOM\Models\Traits\HasMetric;

/**
 * @property string $metric
 * @property int $kills
 * @property int $rank
 * @property Player|null $player
 */
class Boss extends BaseModel
{
    use HasRank, HasMetric;

    protected array $casts = [
        'player' => Player::class
    ];
}