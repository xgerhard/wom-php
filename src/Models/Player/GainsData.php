<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;

/**
 * @property SkillsData $skills
 * @property BossesData $bosses
 * @property ActivitiesData $activities
 * @property ComputedData $computed
 */
class GainsData extends BaseModel
{
    protected array $casts = [
        'skills' => SkillsData::class,
        'bosses' => BossesData::class,
        'activities' => ActivitiesData::class,
        'computed' => ComputedData::class,
    ];
}
