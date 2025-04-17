<?php

namespace WOM\Enums;

class Metric extends BaseEnum
{
    public static function all(): array
    {
        return array_merge(
            Skill::all(),
            Activity::all(),
            Boss::all(),
            Computed::all()
        );
    }

    public static function labels(): array
    {
        return array_merge(
            Skill::labels(),
            Activity::labels(),
            Boss::labels(),
            Computed::labels()
        );
    }

    public static function groups(): array
    {
        return [
            'Skill' => Skill::labels(),
            'Activity' => Activity::labels(),
            'Boss' => Boss::labels(),
            'Computed' => Computed::labels(),
        ];
    }

    public static function groupFor(string $metric): ?string
    {
        foreach (self::groups() as $group => $metrics) {
            if (array_key_exists($metric, $metrics)) {
                return $group;
            }
        }
        return null;
    }
}