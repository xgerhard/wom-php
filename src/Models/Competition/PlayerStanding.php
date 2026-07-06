<?php

namespace WOM\Models\Competition;

use WOM\Models\BaseModel;

/**
 * @property int $playerId
 * @property int $competitionId
 * @property string|null $teamName
 * @property string $createdAt
 * @property string $updatedAt
 * @property object $progress
 * @property object $levels
 * @property int $rank
 * @property Competition $competition
 */
class PlayerStanding extends BaseModel
{
    protected array $casts = [
        'competition' => Competition::class,
    ];
}
