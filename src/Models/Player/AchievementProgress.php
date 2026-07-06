<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;
use WOM\Enums\Metric;

/**
 * @property string $name
 * @property Metric $metric
 * @property string $measure
 * @property int $threshold
 * @property int $playerId
 * @property int $currentValue
 * @property float $absoluteProgress
 * @property float $relativeProgress
 * @property string|null $createdAt
 * @property int $accuracy
 */
class AchievementProgress extends BaseModel
{
}
