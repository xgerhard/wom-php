<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;
use WOM\Enums\Metric;

/**
 * @property int $playerId
 * @property string $name
 * @property Metric $metric
 * @property int $threshold
 * @property string $createdAt
 * @property int $accuracy
 * @property string $measure
 * @property Player|null $player
 */
class Achievement extends BaseModel
{
    protected array $casts = [
        'player' => Player::class,
    ];
}
