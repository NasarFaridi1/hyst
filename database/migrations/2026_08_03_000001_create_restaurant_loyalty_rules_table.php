<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('restaurant_loyalty_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('restaurant_id')->constrained('restaurants')->onDelete('cascade');
            $table->decimal('min_order_amount', 10, 2)->default(0.00);
            $table->decimal('reward_amount', 10, 2)->default(0.00);
            $table->integer('expiry_days')->default(30);
            $table->integer('max_uses_per_user')->nullable()->default(null);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restaurant_loyalty_rules');
    }
};
