<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;
use WOM\Models\Traits\HasRank;
use WOM\Models\Traits\HasMetric;

class Activity extends BaseModel
{
    use HasRank, HasMetric;
}