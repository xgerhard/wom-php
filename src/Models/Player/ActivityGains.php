<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;
use WOM\Models\Delta\GainsEntry;

/**
 * @property string $metric
 * @property GainsEntry $score
 * @property GainsEntry $rank
 */
class ActivityGains extends BaseModel
{
    protected array $casts = [
        'score' => GainsEntry::class,
        'rank' => GainsEntry::class,
    ];
}
