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
        if (Schema::hasTable('gift_cards')) {
            Schema::table('gift_cards', function (Blueprint $table) {
                if (!Schema::hasColumn('gift_cards', 'applicable_type')) {
                    $table->string('applicable_type')->default('all')->after('status'); // all, delivery, dine_in, takeaway
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('gift_cards')) {
            Schema::table('gift_cards', function (Blueprint $table) {
                if (Schema::hasColumn('gift_cards', 'applicable_type')) {
                    $table->dropColumn('applicable_type');
                }
            });
        }
    }
};
