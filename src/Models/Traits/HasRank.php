<?php

namespace WOM\Models\Traits;

trait HasRank
{
    public function isRanked(): bool
    {
        return isset($this->rank) && $this->rank !== -1;
    }

    public function formattedRank(): string
    {
        if (!$this->isRanked()) {
            return '-';
        }

        return $this->formatNumber($this->rank);
    }

    protected function formatNumber(int $number): string
    {
        if ($number >= 1_000_000) {
            return number_format($number / 1_000_000, 2) . 'm';
        }

        if ($number >= 1_000) {
            return number_format($number / 1_000, 2) . 'k';
        }

        return (string) $number;
    }
}