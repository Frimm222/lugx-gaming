<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')
                ->constrained()
                ->onDelete('cascade');          // удаляем отзывы при удалении игры

            $table->foreignId('user_id')          // кто оставил отзыв
            ->constrained()
                ->onDelete('restrict');         // или 'set null' / 'cascade' — по вашему выбору

            $table->integer('rating')->unsigned()->default(5);  // 1–5 или 1–10
            $table->text('comment')->nullable();
            $table->string('title')->nullable();                // заголовок отзыва (опционально)

            $table->boolean('is_verified')->default(false);     // проверенный покупатель?
            $table->boolean('is_published')->default(true);     // модерация

            $table->timestamps();

            // Опционально: уникальность одного отзыва от пользователя на игру
            $table->unique(['game_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
