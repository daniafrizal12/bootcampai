<?php

namespace App\Enums;

enum QueuePriority: string
{
    case Normal = 'normal';
    case Priority = 'priority';
    case Emergency = 'emergency';

    public function getLabel(): string
    {
        return match ($this) {
            self::Normal => 'Reguler / Normal',
            self::Priority => 'Prioritas (Lansia/Ibu Hamil/Difabel)',
            self::Emergency => 'Darurat / Cito',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Normal => 'gray',
            self::Priority => 'warning',
            self::Emergency => 'danger',
        };
    }
}
