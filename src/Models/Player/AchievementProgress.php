<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;

/**
 * @property string $name
 * @property string $metric
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
