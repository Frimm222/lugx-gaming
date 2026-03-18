<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        // Получаем всех пользователей и игры
        $users = User::inRandomOrder()->limit(8)->get(); // возьмём до 8 пользователей
        $games = Game::all();

        if ($users->isEmpty() || $games->isEmpty()) {
            $this->command->warn('Нет пользователей или игр в базе. Отзывы не созданы.');
            return;
        }

        $reviewTemplates = [
            [
                'positive' => [
                    'title'   => ['Отличная игра!', 'Шедевр!', 'Must play', 'Очень зашло', 'Рекомендую на 100%'],
                    'comment' => [
                        'Графика на высоте, сюжет держит в напряжении до самого конца. Лучший шутер за последние годы!',
                        'Просто бомба! Мультиплеер затягивает, кампания шикарная, хочется играть ещё и ещё.',
                        'После 40+ часов игры всё ещё не надоела. Атмосфера, геймплей, музыка — всё на уровне.',
                        'Очень круто сделано. Особенно понравились миссии ночью и перестрелки в дождь.',
                        'Купил за скидку — и ни капли не жалею. Одна из лучших частей серии.',
                    ],
                ],
                'negative' => [
                    'title'   => ['Разочарование', 'Не зашло', 'Переоценённая игра', 'Много багов', 'Скучно'],
                    'comment' => [
                        'Ожидал большего. Много багов на релизе, оптимизация ужасная.',
                        'Сюжет предсказуемый, мультиплеер однообразный. Прошёл и забыл.',
                        'Графика хорошая, но геймплей устарел. Платишь за бренд, а не за качество.',
                        'Слишком много микротранзакций и сезонов. Ощущение, что это не полноценная игра.',
                        'После 5 часов играть уже не хочется. Ничего нового не придумали.',
                    ],
                ],
                'neutral' => [
                    'title'   => ['Нормально', 'Среднячок', 'Неплохо', 'На один раз', 'Есть лучше'],
                    'comment' => [
                        'Игра нормальная, но ничего выдающегося. Прошёл кампанию и хватит.',
                        'Для фанатов серии пойдёт, остальным можно и пропустить.',
                        'Графика радует глаз, но в остальном — типичный Call of Duty.',
                        'Можно поиграть на выходных, но не шедевр и не провал.',
                        'Средний представитель жанра. Ни восторга, ни сильного отторжения.',
                    ],
                ],
            ],
            // Можно добавить другие шаблоны для других жанров, если хочешь разнообразия
        ];

        $reviewTemplates = $reviewTemplates[0]; // берём первый набор

        $count = 0;

        foreach ($games as $game) {
            // Сколько отзывов хотим на игру (но не больше, чем пользователей)
            $maxReviews = min(rand(3, 7), $users->count());

            // Берём случайных уникальных пользователей для этой игры
            $selectedUsers = $users->random($maxReviews);

            foreach ($selectedUsers as $user) {
                // Проверяем, нет ли уже отзыва от этого пользователя на эту игру
                if (Review::where('game_id', $game->id)->where('user_id', $user->id)->exists()) {
                    continue; // пропускаем, если уже есть
                }

                $typeChance = rand(1, 100);
                if ($typeChance <= 60) {
                    $type = 'positive';
                    $rating = rand(4, 5);
                } elseif ($typeChance <= 80) {
                    $type = 'neutral';
                    $rating = 3;
                } else {
                    $type = 'negative';
                    $rating = rand(1, 2);
                }

                $title   = $reviewTemplates[$type]['title'][array_rand($reviewTemplates[$type]['title'])];
                $comment = $reviewTemplates[$type]['comment'][array_rand($reviewTemplates[$type]['comment'])];

                Review::create([
                    'game_id'      => $game->id,
                    'user_id'      => $user->id,
                    'rating'       => $rating,
                    'title'        => $title,
                    'comment'      => $comment . "\n\n" . fake()->sentence(rand(10, 30)),
                    'is_verified'  => rand(0, 100) > 25,
                    'is_published' => true,
                    'created_at'   => now()->subDays(rand(5, 365)),
                    'updated_at'   => now(),
                ]);

                $count++;
            }
        }

        $this->command->info("Создано отзывов: $count");

        // Опционально: пересчитать средний рейтинг и количество
        foreach (Game::all() as $game) {
            $avg   = $game->reviews()->avg('rating') ?? 0;
            $count = $game->reviews()->count();

            $game->updateQuietly([
                'rating_average' => round($avg, 1),
                'rating_count'   => $count,
            ]);
        }
    }
}
