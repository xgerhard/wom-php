<?php

namespace WOM\Models\Delta;

use WOM\Models\BaseModel;
use WOM\Models\Player\Player;
use WOM\Models\Traits\HasRank;

/**
 * @property Player $player
 * @property int $playerId
 * @property string $startDate
 * @property string $endDate
 * @property int $gained
 */
class LeaderboardEntry extends BaseModel
{
    use HasRank;

    protected array $casts = [
        'player' => Player::class,
    ];
}
