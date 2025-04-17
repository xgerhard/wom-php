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

    public function hasExperience(): bool
    {
        return isset($this->experience) && $this->experience !== -1;
    }

    public function formatExperience(): string
    {
        if (!$this->hasExperience()) {
            return '-';
        }

        return $this->formatNumber($this->experience);
    }
}