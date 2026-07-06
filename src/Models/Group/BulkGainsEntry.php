<?php

namespace WOM\Models\Group;

use WOM\Models\BaseModel;
use WOM\Models\Delta\GainsEntry;
use WOM\Models\Player\Player;

/**
 * @property Player $player
 * @property string $startDate
 * @property string $endDate
 * @property object $data Per-metric gains (array of GainsEntry)
 */
class BulkGainsEntry extends BaseModel
{
    protected array $casts = [
        'player' => Player::class,
        'data' => [
            'type' => GainsEntry::class,
            'many' => true,
        ],
    ];
}
