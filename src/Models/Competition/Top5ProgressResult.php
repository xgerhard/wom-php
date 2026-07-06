<?php

namespace WOM\Models\Competition;

use WOM\Models\BaseModel;
use WOM\Models\Player\Player;
use WOM\Models\Player\TimelineDatapoint;

/**
 * @property Player $player
 * @property TimelineDatapoint[] $history
 */
class Top5ProgressResult extends BaseModel
{
    protected array $casts = [
        'player' => Player::class,
        'history' => [
            'type' => TimelineDatapoint::class,
            'many' => true,
        ],
    ];
}