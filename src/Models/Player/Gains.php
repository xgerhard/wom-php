<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;

/**
 * @property string $startsAt
 * @property string $endsAt
 * @property GainsData $data
 */
class Gains extends BaseModel
{
    protected array $casts = [
        'data' => GainsData::class,
    ];
}
