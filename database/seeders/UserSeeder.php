<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Админ (по email — безопасно)
        User::firstOrCreate(
            ['email' => 'admin@shop.test'],
            [
                'name'                => 'Admin',
                'nickname'            => 'AdminGod',
                'password'            => Hash::make('password'),
                'is_verified'         => true,
                'balance'             => 150.00,
                'country'             => 'UA',
                'receives_newsletter' => true,
            ]
        );

        // 2. Несколько фиксированных тестовых пользователей (тоже по email)
        $testUsers = [
            [
                'email'     => 'test1@shop.test',
                'name'      => 'Pedro Ondricka',
                'nickname'  => 'ShadowKiller',
                'country'   => 'UA',
                'city'      => 'Sevastopol',
                'balance'   => 34.89,
            ],
            [
                'email'     => 'test2@shop.test',
                'name'      => 'Alex Gamer',
                'nickname'  => 'PixelMaster',
                'country'   => 'UA',
                'balance'   => 12.50,
            ],
            [
                'email'     => 'test3@shop.test',
                'name'      => 'Maria Play',
                'nickname'  => 'QueenOfNoobs',
                'country'   => 'UA',
                'balance'   => 67.30,
            ],
        ];

        foreach ($testUsers as $data) {
            User::firstOrCreate(
                ['email' => $data['email']],
                array_merge($data, [
                    'password'            => Hash::make('password'),
                    'receives_newsletter' => true,
                    'is_verified'         => true,
                ])
            );
        }

        // 3. Остальные случайные пользователи через factory (без жёстких ников)
        User::factory()
            ->count(12)                     // сколько нужно
            ->create([
                'password'            => Hash::make('password'),
                'receives_newsletter' => fn() => fake()->boolean(70),
                'balance'             => fn() => fake()->randomFloat(2, 0, 120),
                'country'             => 'UA',
            ]);

        $this->command->info('Создано/обновлено пользователей: ' . User::count());
    }
}
