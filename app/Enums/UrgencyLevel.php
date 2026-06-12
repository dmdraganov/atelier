<?php

namespace App\Enums;

enum UrgencyLevel: string
{
    case Standard = 'standard';
    case Fast = 'fast';
    case Urgent = 'urgent';

    public function label(): string
    {
        return match ($this) {
            self::Standard => 'Стандартный срок',
            self::Fast => 'Ускоренно',
            self::Urgent => 'Срочно',
        };
    }

    public function multiplier(): float
    {
        return match ($this) {
            self::Standard => 1.0,
            self::Fast => 1.2,
            self::Urgent => 1.5,
        };
    }
}
