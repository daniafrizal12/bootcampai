<?php

namespace App\Enums;

enum ScheduleType: string
{
    case Recurring = 'recurring';
    case OneTime = 'one_time';

    public function getLabel(): string
    {
        return match ($this) {
            self::Recurring => __('Recurring (Weekly)'),
            self::OneTime => __('One-time (Specific Date)'),
        };
    }
}
