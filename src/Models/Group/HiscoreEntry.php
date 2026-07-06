<?php

namespace WOM\Models\Group;

use WOM\Models\BaseModel;
use WOM\Models\Player\Player;

/**
 * @property Player $player
 * @property HiscoreData $data
 */
class HiscoreEntry extends BaseModel
{
    protected array $casts = [
        'player' => Player::class,
        'data' => HiscoreData::class,
    ];
}
