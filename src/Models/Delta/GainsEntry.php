<?php

namespace WOM\Models\Delta;

use WOM\Models\BaseModel;
use WOM\Models\Traits\HasRank;

/**
 * @property string|null $metric
 * @property int $gained
 * @property int $start
 * @property int $end
 */
class GainsEntry extends BaseModel
{
    use HasRank;

    public function formatGained(): string
    {
        return $this->formatNumber($this->gained);
    }

    public function formatStart(): string
    {
        return $this->formatNumber($this->start);
    }

    public function formatEnd(): string
    {
        return $this->formatNumber($this->end);
    }
}
