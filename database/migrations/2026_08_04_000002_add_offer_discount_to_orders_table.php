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
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (!Schema::hasColumn('orders', 'offer_discount')) {
                    $table->decimal('offer_discount', 10, 2)->default(0.00);
                }
                if (!Schema::hasColumn('orders', 'offer_title')) {
                    $table->string('offer_title')->nullable();
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table) {
                if (Schema::hasColumn('orders', 'offer_discount')) {
                    $table->dropColumn('offer_discount');
                }
                if (Schema::hasColumn('orders', 'offer_title')) {
                    $table->dropColumn('offer_title');
                }
            });
        }
    }
};
