<?php

namespace WOM\Models\Competition;

use WOM\Models\BaseModel;
use WOM\Models\Group\Group;
use WOM\Models\Competition\PlayerParticipation;

/**
 * @property int $id
 * @property string $title
 * @property string $metric
 * @property array $metrics
 * @property string $type
 * @property string $startsAt
 * @property string $endsAt
 * @property int|null $groupId
 * @property int $score
 * @property string $createdAt
 * @property string $updatedAt
 * @property int $participantCount
 * @property Group|null $group
 * @property PlayerParticipation[] $participations
 */
class Details extends BaseModel
{
    protected array $casts = [
        'group' => Group::class,
        'participations' => [
            'type' => PlayerParticipation::class,
            'many' => true
        ]
    ];
}