<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;

/**
 * @property int $playerId
 * @property string $name
 * @property string $metric
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
