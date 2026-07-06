<?php

namespace WOM\Models\Group;

use WOM\Models\BaseModel;
use WOM\Models\Group\MetricLeaders;
use WOM\Models\Player\Snapshot;

/**
 * @property int $maxedCombatCount
 * @property int $maxedTotalCount
 * @property int $maxed200msCount
 * @property \WOM\Models\Player\Snapshot $averageStats
 * @property MetricLeaders $metricLeaders
 */
class Statistics extends BaseModel
{
    protected array $casts = [
        'averageStats' => Snapshot::class,
        'metricLeaders' => MetricLeaders::class
    ];
}