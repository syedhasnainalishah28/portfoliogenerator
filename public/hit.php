<?php

/**
 * HA Tech - System Automation "Hit" File
 * This file allows triggering the Laravel Scheduler via a URL.
 * Secure this with a secret key if necessary.
 */

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Load Composer Autoloader
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel
$app = require_once __DIR__.'/../bootstrap/app.php';

// Run the Scheduler
$kernel = $app->make(Kernel::class);

echo "--- HA Tech Automation Engine ---\n";
echo "Initializing dispatch sequence...\n\n";

try {
    // This runs the scheduled tasks (License checks, etc.)
    $status = $kernel->call('schedule:run');
    echo "Dispatched successfully. Status Code: " . $status . "\n";
    echo "License expiry checks and system cleanups completed.";
} catch (\Exception $e) {
    echo "ERROR during dispatch: " . $e->getMessage();
}
