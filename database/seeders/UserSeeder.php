<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@atelier.test'],
            [
                'name' => 'Администратор Ателье',
                'password' => 'password',
                'phone' => '+7 900 100-10-10',
                'role' => UserRole::Admin,
            ],
        );

        User::query()->updateOrCreate(
            ['email' => 'master@atelier.test'],
            [
                'name' => 'Мария Петрова',
                'password' => 'password',
                'phone' => '+7 900 200-20-20',
                'role' => UserRole::Master,
            ],
        );

        User::query()->updateOrCreate(
            ['email' => 'customer@atelier.test'],
            [
                'name' => 'Анна Иванова',
                'password' => 'password',
                'phone' => '+7 900 300-30-30',
                'role' => UserRole::Customer,
            ],
        );
    }
}
