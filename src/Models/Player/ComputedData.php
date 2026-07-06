<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;

class ComputedData extends BaseModel
{
    protected function resolvePropertyValue(string $key, $value)
    {
        return new ComputedGains($value);
    }
}
