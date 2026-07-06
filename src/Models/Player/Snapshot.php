<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;

/**
 * @property int $playerId
 * @property string $createdAt
 * @property string|null $importedAt
 * @property SnapshotData $data
 */
class Snapshot extends BaseModel
{
    protected array $casts = [
        'data' => SnapshotData::class,
    ];
}