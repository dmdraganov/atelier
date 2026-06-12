<?php

namespace App\Enums;

enum ComplexityLevel: string
{
    case Simple = 'simple';
    case Medium = 'medium';
    case Complex = 'complex';

    public function label(): string
    {
        return match ($this) {
            self::Simple => 'Простой',
            self::Medium => 'Средний',
            self::Complex => 'Сложный',
        };
    }

    public function multiplier(): float
    {
        return match ($this) {
            self::Simple => 1.0,
            self::Medium => 1.25,
            self::Complex => 1.5,
        };
    }
}
