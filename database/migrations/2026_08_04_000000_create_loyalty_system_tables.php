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
        // 1. Loyalty Rules (Restaurant Configuration)
        if (!Schema::hasTable('loyalty_rules')) {
            Schema::create('loyalty_rules', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('restaurant_id');
                $table->string('name');
                $table->decimal('minimum_order_amount', 10, 2)->default(20.00);
                $table->enum('reward_type', ['fixed', 'percentage'])->default('fixed');
                $table->decimal('reward_value', 10, 2);
                $table->integer('expiry_days')->default(30);
                $table->integer('max_usage')->default(1);
                $table->tinyInteger('is_active')->default(1);
                $table->timestamps();

                $table->index('restaurant_id', 'idx_restaurant');
            });
        }

        // 2. Rewards Earned By Customers
        if (!Schema::hasTable('loyalty_rewards')) {
            Schema::create('loyalty_rewards', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('restaurant_id');
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('order_id');
                $table->unsignedBigInteger('loyalty_rule_id');
                $table->enum('reward_type', ['fixed', 'percentage']);
                $table->decimal('reward_value', 10, 2);
                $table->enum('status', ['available', 'used', 'expired'])->default('available');
                $table->integer('usage_count')->default(0);
                $table->integer('max_usage')->default(1);
                $table->dateTime('expires_at')->nullable();
                $table->timestamps();

                $table->index('user_id', 'idx_user');
                $table->index('restaurant_id', 'idx_restaurant');
                $table->index('status', 'idx_status');
                $table->index('expires_at', 'idx_expires');
            });
        }

        // 3. Reward Usage History
        if (!Schema::hasTable('loyalty_reward_usages')) {
            Schema::create('loyalty_reward_usages', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('loyalty_reward_id');
                $table->unsignedBigInteger('order_id');
                $table->decimal('discount_amount', 10, 2);
                $table->timestamp('created_at')->useCurrent();

                $table->index('loyalty_reward_id', 'idx_reward');
                $table->index('order_id', 'idx_order');
            });
        }

        // 4. Ensure loyalty columns exist on orders table
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (!Schema::hasColumn('orders', 'loyalty_reward_id')) {
                    $table->unsignedBigInteger('loyalty_reward_id')->nullable();
                }
                if (!Schema::hasColumn('orders', 'loyalty_discount')) {
                    $table->decimal('loyalty_discount', 10, 2)->default(0.00);
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loyalty_reward_usages');
        Schema::dropIfExists('loyalty_rewards');
        Schema::dropIfExists('loyalty_rules');

        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (Schema::hasColumn('orders', 'loyalty_reward_id')) {
                    $table->dropColumn('loyalty_reward_id');
                }
                if (Schema::hasColumn('orders', 'loyalty_discount')) {
                    $table->dropColumn('loyalty_discount');
                }
            });
        }
    }
};
