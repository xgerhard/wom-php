<?php

namespace WOM\Models\Traits;

use WOM\Enums\Metric;

trait HasMetric
{
    public function metricLabel(): string
    {
        return Metric::label($this->metric);
    }
}