<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;
use WOM\Enums\Player\Country;
use WOM\Enums\Player\Build;
use WOM\Enums\Player\Status;
use WOM\Enums\Player\Type;

/**
 * @property int $id
 * @property string $username
 * @property string $displayName
 * @property Type $type
 * @property Build $build
 * @property Country|null $country
 * @property Status $status
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
