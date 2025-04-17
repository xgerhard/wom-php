<?php

namespace WOM\Models\Player;

use WOM\Models\BaseModel;
use WOM\Models\Player\Player;
use WOM\Models\Traits\HasRank;
use WOM\Models\Traits\HasMetric;

class Skill extends BaseModel
{
    use HasRank, HasMetric;

    protected array $casts = [
        'player' => Player::class
    ];

    public function formattedExperience(): string
    {
        if (!$this->isRanked()) {
            return '-';
        }

        return $this->formatNumber($this->experience);
    }
}