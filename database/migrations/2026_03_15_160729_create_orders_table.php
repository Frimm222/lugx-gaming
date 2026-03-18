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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('order_number')->unique();       // ORD-20260315-12345
            $table->decimal('total', 10, 2);
            $table->string('status')->default('pending');   // pending, paid, completed, cancelled
            $table->string('payment_method')->nullable();   // card, balance, etc.
            $table->json('payment_data')->nullable();       // для ответа от платёжки
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
