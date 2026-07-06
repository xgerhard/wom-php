<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;

class SkillsData extends BaseModel
{
    protected function resolvePropertyValue(string $key, $value)
    {
        return new SkillGains($value);
    }
}
