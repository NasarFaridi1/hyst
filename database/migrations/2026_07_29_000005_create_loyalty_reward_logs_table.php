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
                $table->unsignedBigInteger('restaurant_id')->index();
                $table->unsignedBigInteger('user_id')->index();
                $table->string('reward_type')->default('birthday'); // birthday, festival
                $table->string('festival_name')->nullable();
                $table->string('subject');
                $table->text('message');
                $table->json('offers')->nullable();
                $table->string('status')->default('sent'); // sent, failed
                $table->text('error_message')->nullable();
                $table->timestamp('sent_at')->useCurrent();
                $table->timestamps();
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
