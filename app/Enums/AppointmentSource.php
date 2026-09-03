<?php

namespace App\Enums;

enum AppointmentSource: string
{
    case Online = 'online';
    case WalkIn = 'walk_in';
    case Phone = 'phone';

    public function getLabel(): string
    {
        return match ($this) {
            self::Online => 'Online Portal',
            self::WalkIn => 'Walk-In / Langsung',
            self::Phone => 'Telepon / CS',
        };
    }
}
