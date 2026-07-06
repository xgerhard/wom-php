<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;

/**
 * @property int $playerId
 * @property string $previousUsername
 * @property string $archiveUsername
 * @property string|null $restoredUsername
 * @property string $createdAt
 * @property string|null $restoredAt
 * @property Player|null $player
 */
class Archive extends BaseModel
{
    protected array $casts = [
        'player' => Player::class,
    ];
}
