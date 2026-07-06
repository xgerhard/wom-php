<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;
use WOM\Models\Delta\GainsEntry;

/**
 * @property string $metric
 * @property GainsEntry $value
 * @property GainsEntry $rank
 */
class ComputedGains extends BaseModel
{
    protected array $casts = [
        'value' => GainsEntry::class,
        'rank'  => GainsEntry::class,
    ];
}
