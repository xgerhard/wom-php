<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;

class BossesData extends BaseModel
{
    protected function resolvePropertyValue(string $key, $value)
    {
        return new BossGains($value);
    }
}
