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
 * @property float $ttm200m
 * @property string $registeredAt
 * @property string|null $updatedAt
 * @property string|null $lastChangedAt
 * @property string|null $lastImportedAt
 */
class Player extends BaseModel
{
}
