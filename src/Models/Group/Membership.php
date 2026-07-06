<?php

namespace WOM\Models\Group;

use WOM\Models\BaseModel;
use WOM\Models\Player\Player;

/**
 * @property int $playerId
 * @property int $groupId
 * @property string $role
 * @property string|null $clientSyncJoinedAt
 * @property string $createdAt
 * @property string $updatedAt
 * @property Player $player
 */
class Membership extends BaseModel
{
    protected array $casts = [
        'player' => Player::class,
    ];
}
