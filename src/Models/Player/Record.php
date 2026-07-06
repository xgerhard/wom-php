<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;
use WOM\Models\Traits\HasMetric;
use WOM\Enums\Metric;
use WOM\Enums\Period;

/**
 * @property int $id
 * @property int $playerId
 * @property Period $period
 * @property Metric $metric
 * @property int $value
 * @property string $updatedAt
 */
class Record extends BaseModel
{
    use HasMetric;
}
