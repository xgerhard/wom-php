<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;
use WOM\Models\Traits\HasRank;
use WOM\Models\Traits\HasMetric;

/**
 * @property string $metric
 * @property int $score
 * @property int $rank
 * @property Player|null $player
 */
class Activity extends BaseModel
{
    use HasRank, HasMetric;

    protected array $casts = [
        'player' => Player::class
    ];
}