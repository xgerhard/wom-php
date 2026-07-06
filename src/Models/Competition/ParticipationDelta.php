<?php

namespace WOM\Models\Competition;

use WOM\Models\BaseModel;
use WOM\Models\Delta\GainsEntry;

/**
 * @property string $metric
 * @property GainsEntry $values
 * @property GainsEntry $levels
 */
class ParticipationDelta extends BaseModel
{
    protected array $casts = [
        'values' => GainsEntry::class,
        'levels' => GainsEntry::class,
    ];
}
