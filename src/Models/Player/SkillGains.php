<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;
use WOM\Models\Delta\GainsEntry;

/**
 * @property string $metric
 * @property GainsEntry $experience
 * @property GainsEntry $ehp
 * @property GainsEntry $rank
 * @property GainsEntry $level
 */
class SkillGains extends BaseModel
{
    protected array $casts = [
        'experience' => GainsEntry::class,
        'ehp' => GainsEntry::class,
        'rank' => GainsEntry::class,
        'level' => GainsEntry::class,
    ];
}
