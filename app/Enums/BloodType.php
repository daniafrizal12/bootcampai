<?php

namespace App\Enums;

enum BloodType: string
{
    case A = 'A';
    case B = 'B';
    case AB = 'AB';
    case O = 'O';

    public function getLabel(): string
    {
        return match ($this) {
            self::A => __('Blood Type A'),
            self::B => __('Blood Type B'),
            self::AB => __('Blood Type AB'),
            self::O => __('Blood Type O'),
        };
    }
}
