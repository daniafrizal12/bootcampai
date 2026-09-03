<?php

namespace App\Enums;

enum QueueStatus: string
{
    case Waiting = 'waiting';
    case Serving = 'serving';
    case Completed = 'completed';
    case Skipped = 'skipped';
    case Cancelled = 'cancelled';

    public function getLabel(): string
    {
        return match ($this) {
            self::Waiting => 'Menunggu',
            self::Serving => 'Sedang Dilayani',
            self::Completed => 'Selesai',
            self::Skipped => 'Dilewati',
            self::Cancelled => 'Batal',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Waiting => 'info',
            self::Serving => 'warning',
            self::Completed => 'success',
            self::Skipped => 'danger',
            self::Cancelled => 'gray',
        };
    }
}
