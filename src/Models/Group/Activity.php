<?php

namespace WOM\Models\Group;

use WOM\Models\BaseModel;
use WOM\Models\Player\Player;

/**
 * @property int $groupId
 * @property int $playerId
 * @property string $type
 * @property string|null $role
 * @property string $createdAt
 * @property Player $player
 */
class Activity extends BaseModel
{
    protected array $casts = [
        'player' => Player::class
    ];
}