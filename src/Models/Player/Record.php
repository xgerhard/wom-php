<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;
use WOM\Models\Traits\HasMetric;

/**
 * @property int $id
 * @property int $playerId
 * @property string $period
 * @property string $metric
 * @property int $value
 * @property string $updatedAt
 */
class Record extends BaseModel
{
    use HasMetric;
}
