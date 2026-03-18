<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('game_genre', function (Blueprint $table) {
            $table->foreignId('game_id')->constrained()->onDelete('cascade');
            $table->foreignId('genre_id')->constrained()->onDelete('cascade');
            $table->primary(['game_id', 'genre_id']); // составной первичный ключ
            // $table->timestamps();   ← обычно не нужны в pivot
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_genre');
    }
};
