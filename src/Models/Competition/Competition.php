<?php

namespace WOM\Models\Competition;

use WOM\Models\BaseModel;
use WOM\Models\Group\Group;
use WOM\Models\Traits\HasMetric;
use WOM\Enums\Metric;

/**
 * @property int $id
 * @property string $title
 * @property Metric $metric
 * @property array $metrics
 * @property string $type
 * @property string $startsAt
 * @property string $endsAt
 * @property int|null $groupId
 * @property int $score
 * @property string $createdAt
 * @property string $updatedAt
 * @property Group|null $group
 * @property int $participantCount
 */
class Competition extends BaseModel
{
    use HasMetric;

    protected array $casts = [
        'group' => Group::class,
        'participations' => [
            'type' => PlayerParticipation::class,
            'many' => true,
        ],
    ];
}
