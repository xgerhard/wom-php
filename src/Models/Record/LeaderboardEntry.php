<?php

namespace WOM\Models\Record;

use WOM\Models\BaseModel;
use WOM\Models\Player\Player;
use WOM\Models\Traits\HasMetric;

/**
 * @property int $id
 * @property int $playerId
 * @property string $period
 * @property string $metric
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
