<?php

namespace WOM\Models\Group;

use WOM\Models\BaseModel;
use WOM\Models\Group\MetricLeaders;
use WOM\Models\Player\Snapshot;

class Statistics extends BaseModel
{
    protected array $casts = [
        'averageStats' => Snapshot::class,
        'metricLeaders' => MetricLeaders::class
    ];
}