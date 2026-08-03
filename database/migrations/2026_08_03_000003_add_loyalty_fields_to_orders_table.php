<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'loyalty_reward_id')) {
                $table->foreignId('loyalty_reward_id')->nullable()->after('gift_card_amount')->constrained('user_loyalty_rewards')->onDelete('set null');
            }
            if (!Schema::hasColumn('orders', 'loyalty_discount')) {
                $table->decimal('loyalty_discount', 10, 2)->default(0.00)->after('loyalty_reward_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'loyalty_reward_id')) {
                $table->dropForeign(['loyalty_reward_id']);
                $table->dropColumn('loyalty_reward_id');
            }
            if (Schema::hasColumn('orders', 'loyalty_discount')) {
                $table->dropColumn('loyalty_discount');
            }
        });
    }
};
