<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;
use WOM\Models\Delta\GainsEntry;

/**
 * @property string $metric
 * @property GainsEntry $kills
 * @property GainsEntry $ehb
 * @property GainsEntry $rank
 */
class BossGains extends BaseModel
{
    protected array $casts = [
        'kills' => GainsEntry::class,
        'ehb' => GainsEntry::class,
        'rank' => GainsEntry::class,
    ];
}
