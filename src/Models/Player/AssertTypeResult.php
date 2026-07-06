<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;

/**
 * @property Player $player
 * @property bool $changed
 */
class AssertTypeResult extends BaseModel
{
    protected array $casts = [
        'player' => Player::class,
    ];
}
