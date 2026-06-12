<?php

namespace App\Enums;

enum OrderStatus: string
{
    case New = 'new';
    case Confirmed = 'confirmed';
    case InProgress = 'in_progress';
    case Fitting = 'fitting';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::New => 'Новый',
            self::Confirmed => 'Подтвержден',
            self::InProgress => 'В работе',
            self::Fitting => 'Примерка',
            self::Completed => 'Завершен',
            self::Cancelled => 'Отменен',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::New => 'status status-new',
            self::Confirmed => 'status status-confirmed',
            self::InProgress => 'status status-progress',
            self::Fitting => 'status status-fitting',
            self::Completed => 'status status-completed',
            self::Cancelled => 'status status-cancelled',
        };
    }
}
