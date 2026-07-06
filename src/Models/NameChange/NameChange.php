<?php

namespace WOM\Models\NameChange;

use WOM\Models\BaseModel;
use WOM\Models\Player\Player;

/**
 * @property int $id
 * @property int $playerId
 * @property string $oldName
 * @property string $newName
 * @property string $status
 * @property mixed|null $reviewContext
 * @property string|null $resolvedAt
 * @property string $updatedAt
 * @property string $createdAt
 * @property Player|null $player
 */
class NameChange extends BaseModel
{
    protected array $casts = [
        'player' => Player::class,
    ];
}
