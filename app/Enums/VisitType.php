<?php

namespace App\Enums;

enum VisitType: string
{
    case NewVisit = 'new_visit';
    case FollowUp = 'follow_up';

    public function getLabel(): string
    {
        return match ($this) {
            self::NewVisit => __('New Visit'),
            self::FollowUp => __('Follow-up Visit'),
        };
    }
}
