<?php

namespace WOM\Models\Group;

use WOM\Models\BaseModel;
use WOM\Models\Delta\GainsEntry as DeltaGainsEntry;
use WOM\Models\Player\Player;

/**
 * @property Player $player
 * @property string $startDate
 * @property string $endDate
 * @property DeltaGainsEntry $data
 */
class GainsEntry extends BaseModel
{
    protected array $casts = [
        'player' => Player::class,
        'data' => DeltaGainsEntry::class,
    ];
}
