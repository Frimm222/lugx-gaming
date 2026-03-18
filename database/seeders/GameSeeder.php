<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Genre;
use App\Models\Platform;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Создаём / получаем жанры
        $genreMap = $this->seedGenres();

        // 2. Создаём / получаем платформы
        $platformMap = $this->seedPlatforms();

        // 3. Создаём / получаем популярные теги
        $tagMap = $this->seedTags();

        // 4. Игры
        $gamesData = [
            [
                'title'             => 'Call of Duty: Modern Warfare II',
                'slug'              => 'call-of-duty-modern-warfare-ii',
                'short_description' => 'Интенсивный шутер от первого лица с мощной кампанией, мультиплеером и спецоперациями.',
                'description'       => "Call of Duty: Modern Warfare II — это продолжение перезапущенной серии...",
                'price'             => 59.99,
                'discount_price'    => 44.99,
                'original_price'    => 69.99,
                'cover_image'       => 'images/mw2-icon.png',
                'game_id_code'      => 'COD MWII',
                'release_date'      => '2022-10-28',
                'developer'         => 'Infinity Ward',
                'publisher'         => 'Activision',
                'is_on_sale'        => true,
                'is_featured'       => true,
                'genres'            => ['Action', 'Shooter', 'FPS'],
                'platforms'         => ['PC', 'PlayStation 5', 'Xbox Series X|S'],
                'tags'              => ['Multiplayer', 'Single Player', 'War', 'Battle', 'Competitive'],
            ],
            [
                'title'             => 'Elden Ring',
                'slug'              => 'elden-ring',
                'short_description' => 'Открытый мир, сложные бои и глубокая история от FromSoftware и Джорджа Мартина.',
                'description'       => "Elden Ring — action/RPG в открытом мире...",
                'price'             => 59.99,
                'discount_price'    => null,
                'original_price'    => null,
                'cover_image'       => 'images/Elden_Ring_capa.jpg',
                'game_id_code'      => 'ELDEN RING',
                'release_date'      => '2022-02-25',
                'developer'         => 'FromSoftware',
                'publisher'         => 'Bandai Namco Entertainment',
                'is_featured'       => true,
                'genres'            => ['Action', 'RPG', 'Open World', 'Souls-like'],
                'platforms'         => ['PC', 'PlayStation 5', 'PlayStation 4', 'Xbox Series X|S', 'Xbox One'],
                'tags'              => ['Open World', 'Single Player', 'Difficult', 'Fantasy'],
            ],
            [
                'title'             => 'Assassin’s Creed Valhalla',
                'slug'              => 'assassins-creed-valhalla',
                'short_description' => 'Эпическое приключение викингов в открытом мире Англии IX века.',
                'price'             => 39.99,
                'discount_price'    => 19.99,
                'original_price'    => 59.99,
                'cover_image'       => 'images/Assassins_Creed_Valhalla_poster.png',
                'game_id_code'      => 'AC VALH',
                'release_date'      => '2020-11-10',
                'developer'         => 'Ubisoft Montreal',
                'publisher'         => 'Ubisoft',
                'is_on_sale'        => true,
                'genres'            => ['Action', 'Adventure', 'RPG', 'Open World'],
                'platforms'         => ['PC', 'PlayStation 5', 'PlayStation 4', 'Xbox Series X|S', 'Xbox One'],
                'tags'              => ['Historical', 'Open World', 'Single Player', 'Stealth'],
            ],
            [
                'title'             => 'Cyberpunk 2077',
                'slug'              => 'cyberpunk-2077',
                'short_description' => 'Открытый мир будущего в Найт-Сити, киберпанк, стрельба, RPG-элементы и глубокий сюжет.',
                'description'       => "Cyberpunk 2077 — это action-RPG от CD Projekt RED в антиутопическом открытом мире...",
                'price'             => 59.99,
                'discount_price'    => 29.99,
                'original_price'    => 59.99,
                'cover_image'       => 'images/cyberpunk-2077-cover.png',
                'game_id_code'      => 'CYBER2077',
                'release_date'      => '2020-12-10',
                'developer'         => 'CD Projekt RED',
                'publisher'         => 'CD Projekt',
                'is_on_sale'        => true,
                'is_featured'       => false,
                'genres'            => ['Action', 'RPG', 'Open World', 'Cyberpunk'],
                'platforms'         => ['PC', 'PlayStation 5', 'PlayStation 4', 'Xbox Series X|S', 'Xbox One'],
                'tags'              => ['Open World', 'Story Rich', 'Sci-Fi', 'First Person', 'Mature'],
            ],

            [
                'title'             => 'God of War Ragnarök',
                'slug'              => 'god-of-war-ragnarok',
                'short_description' => 'Эпическое приключение Кратоса и Атрея в скандинавской мифологии, сражение с богами и судьбой.',
                'description'       => "God of War Ragnarök — продолжение легендарной саги от Santa Monica Studio...",
                'price'             => 69.99,
                'discount_price'    => null,
                'original_price'    => null,
                'cover_image'       => 'images/god-of-war-ragnarok-cover.png',
                'game_id_code'      => 'GOWR',
                'release_date'      => '2022-11-09',
                'developer'         => 'Santa Monica Studio',
                'publisher'         => 'Sony Interactive Entertainment',
                'is_on_sale'        => false,
                'is_featured'       => true,
                'genres'            => ['Action', 'Adventure', 'Hack and Slash'],
                'platforms'         => ['PlayStation 5', 'PlayStation 4'],
                'tags'              => ['Story Rich', 'Single Player', 'Mythology', 'Combat', 'Emotional'],
            ],

            [
                'title'             => 'Hogwarts Legacy',
                'slug'              => 'hogwarts-legacy',
                'short_description' => 'Открытый мир волшебного мира Гарри Поттера, создание персонажа, учёба в Хогвартсе и магия.',
                'description'       => "Hogwarts Legacy — это action-RPG в мире Гарри Поттера от Avalanche Software...",
                'price'             => 59.99,
                'discount_price'    => 39.99,
                'original_price'    => 59.99,
                'cover_image'       => 'images/hogwarts-legacy-cover.jpg',
                'game_id_code'      => 'HLEGACY',
                'release_date'      => '2023-02-10',
                'developer'         => 'Avalanche Software',
                'publisher'         => 'Warner Bros. Games',
                'is_on_sale'        => true,
                'is_featured'       => true,
                'genres'            => ['Action', 'RPG', 'Open World', 'Fantasy'],
                'platforms'         => ['PC', 'PlayStation 5', 'PlayStation 4', 'Xbox Series X|S', 'Xbox One'],
                'tags'              => ['Magic', 'Open World', 'Single Player', 'Wizarding World'],
            ],

            [
                'title'             => 'The Witcher 3: Wild Hunt',
                'slug'              => 'the-witcher-3-wild-hunt',
                'short_description' => 'Легендарная RPG с огромным открытым миром, монстрами, моральными выборами и охотой на Геральта.',
                'description'       => "The Witcher 3: Wild Hunt — шедевр от CD Projekt RED, признанный одной из лучших игр всех времён...",
                'price'             => 39.99,
                'discount_price'    => 9.99,
                'original_price'    => 39.99,
                'cover_image'       => 'images/witcher-3-cover.jpg',
                'game_id_code'      => 'W3WH',
                'release_date'      => '2015-05-19',
                'developer'         => 'CD Projekt RED',
                'publisher'         => 'CD Projekt',
                'is_on_sale'        => true,
                'is_featured'       => false,
                'genres'            => ['RPG', 'Open World', 'Action'],
                'platforms'         => ['PC', 'PlayStation 5', 'PlayStation 4', 'Xbox Series X|S', 'Nintendo Switch'],
                'tags'              => ['Story Rich', 'Mature', 'Fantasy', 'Choices Matter', 'Monster Hunting'],
            ],

            [
                'title'             => 'Stardew Valley',
                'slug'              => 'stardew-valley',
                'short_description' => 'Расслабляющая фермерская симуляция с элементами RPG, рыбалкой, дружбой и тайнами.',
                'description'       => "Stardew Valley — уютная инди-игра, где вы унаследовали ферму деда и строите свою жизнь...",
                'price'             => 14.99,
                'discount_price'    => null,
                'original_price'    => null,
                'cover_image'       => 'images/stardew-valley-cover.jpg',
                'game_id_code'      => 'SDV',
                'release_date'      => '2016-02-26',
                'developer'         => 'ConcernedApe',
                'publisher'         => 'ConcernedApe',
                'is_on_sale'        => false,
                'is_featured'       => true,
                'genres'            => ['Simulation', 'RPG', 'Indie'],
                'platforms'         => ['PC', 'PlayStation 4', 'Xbox One', 'Nintendo Switch', 'Mobile'],
                'tags'              => ['Farming', 'Relaxing', 'Pixel Art', 'Co-op', 'Life Sim'],
            ],

            [
                'title'             => 'Baldur’s Gate 3',
                'slug'              => 'baldurs-gate-3',
                'short_description' => 'Эпическая пошаговая RPG во вселенной Dungeons & Dragons с невероятной свободой выбора.',
                'description'       => "Baldur’s Gate 3 — шедевр от Larian Studios, продолжение легендарной серии...",
                'price'             => 59.99,
                'discount_price'    => 49.99,
                'original_price'    => 59.99,
                'cover_image'       => 'images/baldurs-gate-3-cover.png',
                'game_id_code'      => 'BG3',
                'release_date'      => '2023-08-03',
                'developer'         => 'Larian Studios',
                'publisher'         => 'Larian Studios',
                'is_on_sale'        => true,
                'is_featured'       => true,
                'genres'            => ['RPG', 'Turn-Based', 'Fantasy'],
                'platforms'         => ['PC', 'PlayStation 5', 'Xbox Series X|S'],
                'tags'              => ['Story Rich', 'Choices Matter', 'Co-op', 'Dungeons & Dragons', 'Tactical'],
            ],

            [
                'title'             => 'Helldivers 2',
                'slug'              => 'helldivers-2',
                'short_description' => 'Кооперативный шутер с хаотичными сражениями против инопланетян и дружеским огнём.',
                'description'       => "Helldivers 2 — это весёлый и сложный кооперативный шутер от Arrowhead Game Studios...",
                'price'             => 39.99,
                'discount_price'    => null,
                'original_price'    => null,
                'cover_image'       => 'images/helldivers-2-cover.jpg',
                'game_id_code'      => 'HD2',
                'release_date'      => '2024-02-08',
                'developer'         => 'Arrowhead Game Studios',
                'publisher'         => 'Sony Interactive Entertainment',
                'is_on_sale'        => false,
                'is_featured'       => false,
                'genres'            => ['Action', 'Shooter', 'Co-op'],
                'platforms'         => ['PC', 'PlayStation 5'],
                'tags'              => ['Co-op', 'Multiplayer', 'Satire', 'Chaotic', 'Third Person'],
            ],
        ];

        foreach ($gamesData as $data) {
            // Извлекаем связи, чтобы не передавать их в create
            $genres    = $data['genres']    ?? [];
            $platforms = $data['platforms'] ?? [];
            $tags      = $data['tags']      ?? [];

            unset($data['genres'], $data['platforms'], $data['tags']);

            $game = Game::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );

            // Привязываем жанры
            if (!empty($genres)) {
                $genreIds = collect($genres)
                    ->map(fn($name) => $genreMap[$name] ?? null)
                    ->filter()
                    ->unique()
                    ->values()
                    ->toArray();

                $game->genres()->sync($genreIds);
            }

            // Привязываем платформы
            if (!empty($platforms)) {
                $platformIds = collect($platforms)
                    ->map(fn($name) => $platformMap[$name] ?? null)
                    ->filter()
                    ->unique()
                    ->values()
                    ->toArray();

                $game->platforms()->sync($platformIds);
            }

            // Привязываем теги
            if (!empty($tags)) {
                $tagIds = collect($tags)
                    ->map(fn($name) => $tagMap[$name] ?? null)
                    ->filter()
                    ->unique()
                    ->values()
                    ->toArray();

                $game->tags()->sync($tagIds);
            }
        }

        $this->command?->info('Игры, жанры, платформы и теги успешно созданы/обновлены.');
    }

    private function seedGenres(): array
    {
        $items = [
            'Action', 'Shooter', 'FPS', 'RPG', 'Adventure', 'Open World',
            'Strategy', 'Sports', 'Racing', 'Simulation', 'Horror', 'Souls-like',
        ];

        $map = [];

        foreach ($items as $name) {
            $genre = Genre::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
            $map[$name] = $genre->id;
        }

        return $map;
    }

    private function seedPlatforms(): array
    {
        $items = [
            ['name' => 'PC',              'slug' => 'pc'],
            ['name' => 'PlayStation 5',   'slug' => 'ps5'],
            ['name' => 'PlayStation 4',   'slug' => 'ps4'],
            ['name' => 'Xbox Series X|S', 'slug' => 'xbox-series'],
            ['name' => 'Xbox One',        'slug' => 'xbox-one'],
            ['name' => 'Nintendo Switch', 'slug' => 'switch'],
        ];

        $map = [];

        foreach ($items as $data) {
            $platform = Platform::firstOrCreate(
                ['slug' => $data['slug']],
                $data
            );
            $map[$data['name']] = $platform->id;
        }

        return $map;
    }

    private function seedTags(): array
    {
        $items = [
            'Multiplayer', 'Single Player', 'Open World', 'Co-op', 'Competitive',
            'Story Rich', 'Difficult', 'Fantasy', 'Historical', 'War', 'Battle',
            'Stealth', 'Indie', 'VR',
        ];

        $map = [];

        foreach ($items as $name) {
            $tag = Tag::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name]
            );
            $map[$name] = $tag->id;
        }

        return $map;
    }
}
