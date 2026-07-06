<?php

namespace WOM\Models\Competition;

use WOM\Models\BaseModel;

/**
 * @property Competition $competition
 * @property string $verificationCode
 */
class CreateCompetitionResult extends BaseModel
{
    protected array $casts = [
        'competition' => Competition::class,
    ];
}
