<?php

namespace WOM\Models\Group;

use WOM\Models\BaseModel;

/**
 * @property Details $group
 * @property string $verificationCode
 */
class CreateGroupResult extends BaseModel
{
    protected array $casts = [
        'group' => Details::class,
    ];
}
