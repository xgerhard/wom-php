<?php

namespace WOM\Models\Competition;

use WOM\Models\BaseModel;
use WOM\Models\Player\Player;

/**
 * @property int $playerId
 * @property int $competitionId
 * @property string|null $teamName
 * @property string $createdAt
 * @property string $updatedAt
 * @property Player $player
 * @property ParticipationDelta[] $deltas
 * @property object $progress
 * @property object $levels
 */
class PlayerParticipation extends BaseModel
{
    protected array $casts = [
        'player' => Player::class,
        'deltas' => [
            'type' => ParticipationDelta::class,
            'many' => true,
        ],
    ];
}
