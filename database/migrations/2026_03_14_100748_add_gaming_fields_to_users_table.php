<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Основные игровые / магазинные поля
            $table->string('nickname')->nullable()->unique()->after('name');           // игровой ник
            $table->string('avatar')->nullable();                                      // путь к аватарке
            $table->date('birth_date')->nullable();                                    // дата рождения (возрастные ограничения)
            $table->string('country')->nullable()->default('UA');                      // страна
            $table->string('city')->nullable();                                        // город (опционально)
            $table->string('phone')->nullable()->unique();                             // телефон для уведомлений/восстановления
            $table->boolean('is_verified')->default(false);                            // верифицированный аккаунт
            $table->boolean('receives_newsletter')->default(true);                     // подписка на рассылку
            $table->decimal('balance', 10, 2)->default(0.00);                          // внутренний баланс (для бонусов, возвратов)

            // Поля для Steam / Epic / etc. интеграции (опционально)
            $table->string('steam_id')->nullable()->unique();
            $table->string('epic_id')->nullable()->unique();
            $table->string('discord_id')->nullable()->unique();

            // Статистика / удобство
            $table->integer('orders_count')->default(0);
            $table->decimal('total_spent', 12, 2)->default(0.00);
            $table->timestamp('last_purchase_at')->nullable();

            // Soft deletes уже есть в default Laravel User
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nickname', 'avatar', 'birth_date', 'country', 'city', 'phone',
                'is_verified', 'receives_newsletter', 'balance',
                'steam_id', 'epic_id', 'discord_id',
                'orders_count', 'total_spent', 'last_purchase_at',
            ]);
        });
    }
};
