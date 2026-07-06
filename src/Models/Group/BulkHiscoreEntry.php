<?php

namespace WOM\Models\Group;

use WOM\Models\BaseModel;
use WOM\Models\Player\Player;
use WOM\Models\Player\Snapshot;

/**
 * @property Player $player
 * @property Snapshot $data
 */
class BulkHiscoreEntry extends BaseModel
{
    protected array $casts = [
        'player' => Player::class,
        'data' => Snapshot::class,
    ];
}
