<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use App\Models\User;

$hasCol = Schema::hasColumn('users', 'fcm_token');
echo "Has fcm_token column: " . ($hasCol ? 'YES' : 'NO') . "\n";
echo "Total users count: " . User::count() . "\n";
