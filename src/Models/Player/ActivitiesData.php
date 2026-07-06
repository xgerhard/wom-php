<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;

class ActivitiesData extends BaseModel
{
    protected function resolvePropertyValue(string $key, $value)
    {
        return new ActivityGains($value);
    }
}
