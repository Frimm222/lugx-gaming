<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->decimal('price', 8, 2);
            $table->decimal('discount_price', 8, 2)->nullable();
            $table->decimal('original_price', 8, 2)->nullable();
            $table->string('cover_image')->nullable();
            $table->string('game_id_code')->nullable(); // COD MMII, etc.
            $table->date('release_date')->nullable();
            $table->string('developer')->nullable();
            $table->string('publisher')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_new')->default(false);
            $table->boolean('is_on_sale')->default(false);
            $table->integer('stock_quantity')->nullable();
            $table->integer('views_count')->default(0);
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->decimal('rating_average', 3, 1)->default(0.0);
            $table->unsignedInteger('rating_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
