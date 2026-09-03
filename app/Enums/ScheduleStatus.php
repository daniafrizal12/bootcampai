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
            self::Active => 'Aktif',
            self::Inactive => 'Nonaktif',
            self::Cancelled => 'Dibatalkan',
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
