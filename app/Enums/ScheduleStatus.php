<?php

namespace App\Enums;

enum ScheduleStatus: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Cancelled = 'cancelled';

    public function getLabel(): string
    {
        return match ($this) {
            self::Active => __('Active'),
            self::Inactive => __('Inactive'),
            self::Cancelled => __('Cancelled'),
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Active => 'success',
            self::Inactive => 'gray',
            self::Cancelled => 'danger',
        };
    }
}
