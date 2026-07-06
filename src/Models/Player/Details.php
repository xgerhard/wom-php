<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;

/**
 * @property int $id
 * @property string $username
 * @property string $displayName
 * @property string $type
 * @property string $build
 * @property string|null $country
 * @property string $status
 * @property bool $patron
 * @property int $exp
 * @property float $ehp
 * @property float $ehb
 * @property float $ttm
 * @property float $tt200m
 * @property string $registeredAt
 * @property string|null $updatedAt
 * @property string|null $lastChangedAt
 * @property string|null $lastImportedAt
 * @property int $combatLevel
 * @property Archive|null $archive
 * @property Annotation[] $annotations
 * @property Snapshot|null $latestSnapshot
 */
class Details extends BaseModel
{
    protected array $casts = [
        'archive' => Archive::class,
        'latestSnapshot' => Snapshot::class,
        'annotations' => [
            'type' => Annotation::class,
            'many' => true,
        ],
    ];
}
