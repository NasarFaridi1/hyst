<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            if (!Schema::hasColumn('restaurants', 'allow_asap')) {
                $table->boolean('allow_asap')->default(1);
            }
            if (!Schema::hasColumn('restaurants', 'allow_schedule')) {
                $table->boolean('allow_schedule')->default(1);
            }
        });
    }

    public function down(): void
    {
        Schema::table('restaurants', function (Blueprint $table) {
            if (Schema::hasColumn('restaurants', 'allow_asap')) {
                $table->dropColumn('allow_asap');
            }
            if (Schema::hasColumn('restaurants', 'allow_schedule')) {
                $table->dropColumn('allow_schedule');
            }
        });
    }
};
