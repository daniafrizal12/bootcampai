<?php

namespace App\Enums;

enum AppointmentStatus: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case CheckedIn = 'checked_in';
    case InProgress = 'in_progress';
    case Completed = 'completed';
    case Cancelled = 'cancelled';
    case NoShow = 'no_show';

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => __('Pending Confirmation'),
            self::Confirmed => __('Confirmed'),
            self::CheckedIn => __('Checked In'),
            self::InProgress => __('In Progress'),
            self::Completed => __('Completed'),
            self::Cancelled => __('Cancelled'),
            self::NoShow => __('No Show'),
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Pending => 'warning',
            self::Confirmed => 'info',
            self::CheckedIn => 'primary',
            self::InProgress => 'warning',
            self::Completed => 'success',
            self::Cancelled => 'danger',
            self::NoShow => 'gray',
        };
    }
}
