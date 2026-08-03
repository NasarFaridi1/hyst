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
        if (!Schema::hasTable('loyalty_reward_logs')) {
            Schema::create('loyalty_reward_logs', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('restaurant_id');
                $table->unsignedBigInteger('user_id');
                $table->string('reward_type')->nullable();
                $table->string('festival_name')->nullable();
                $table->string('subject')->nullable();
                $table->text('message')->nullable();
                $table->json('offers')->nullable();
                $table->string('status')->default('sent');
                $table->text('error_message')->nullable();
                $table->timestamp('sent_at')->nullable();
                $table->timestamps();

                $table->index('restaurant_id');
                $table->index('user_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_reward_logs');
    }
};
