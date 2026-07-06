<?php

namespace WOM\Models\Record;

use WOM\Models\BaseModel;
use WOM\Models\Player\Player;
use WOM\Models\Traits\HasMetric;
use WOM\Enums\Metric;
use WOM\Enums\Period;

/**
 * @property int $id
 * @property int $playerId
 * @property Period $period
 * @property Metric $metric
 * @property int $value
 * @property string $updatedAt
 * @property Player|null $player
 */
class LeaderboardEntry extends BaseModel
{
    use HasMetric;

    protected array $casts = [
        'player' => Player::class,
    ];
}
