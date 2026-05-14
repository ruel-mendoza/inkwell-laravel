<?php
// debug_boot.php
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    echo "1. Loading Autoloader...\n";
    require __DIR__.'/vendor/autoload.php';

    echo "2. Loading App...\n";
    $app = require_once __DIR__.'/bootstrap/app.php';

    echo "3. Booting Kernel...\n";
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    echo "4. Success! Framework is alive.\n";
} catch (\Throwable $e) {
    echo "\n--- BOOT CRASH DETECTED ---\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . " on line " . $e->getLine() . "\n";
    echo "---------------------------\n";
}