<?php

namespace App\Enums;

enum UserRole: string
{
    case Customer = 'customer';
    case Master = 'master';
    case Admin = 'admin';

    public function label(): string
    {
        return match ($this) {
            self::Customer => 'Клиент',
            self::Master => 'Мастер',
            self::Admin => 'Администратор',
        };
    }
}
