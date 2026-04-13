<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    require __DIR__ . '/vendor/autoload.php';
    $app = require_once __DIR__ . '/bootstrap/app.php';
    
    // Attempt to clear caches directly to force healing
    if (file_exists(__DIR__.'/bootstrap/cache/config.php')) @unlink(__DIR__.'/bootstrap/cache/config.php');
    if (file_exists(__DIR__.'/bootstrap/cache/routes-v7.php')) @unlink(__DIR__.'/bootstrap/cache/routes-v7.php');
    if (file_exists(__DIR__.'/bootstrap/cache/packages.php')) @unlink(__DIR__.'/bootstrap/cache/packages.php');
    if (file_exists(__DIR__.'/bootstrap/cache/services.php')) @unlink(__DIR__.'/bootstrap/cache/services.php');

    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $response = $kernel->handle(
        $request = Illuminate\Http\Request::create('/', 'GET')
    );
    
    echo "<h1>Request Status: " . $response->getStatusCode() . "</h1>";
    if ($response->getStatusCode() == 500) {
        echo "<h3>LARAVEL RETURNED A 500 EXCEPTION. LOOK AT LARAVEL.LOG</h3>";
        if (file_exists(__DIR__.'/storage/logs/laravel.log')) {
            echo "<pre>".htmlspecialchars(shell_exec('tail -n 100 ' . escapeshellarg(__DIR__.'/storage/logs/laravel.log')))."</pre>";
        }
    } else {
        echo "<h3>Website rendered perfectly in diagnostic wrapper. Caches have been cleared. Try loading the normal site now.</h3>";
        echo "<hr>";
        echo $response->getContent();
    }
} catch (\Throwable $e) {
    echo "<h1>CRITICAL FATAL SYSTEM ERROR:</h1>";
    echo "<strong>" . get_class($e) . "</strong><br>";
    echo "<b style='color:red'>{$e->getMessage()}</b><br>";
    echo "In file: <i>{$e->getFile()}</i> at line <b>{$e->getLine()}</b><br/><br/>";
    echo "<h3>Stack Trace:</h3><pre>";
    echo $e->getTraceAsString();
    echo "</pre>";
    
    // Check permissions
    echo "<h3>System Diagnostics:</h3>";
    echo "Storage Writable: " . (is_writable(__DIR__.'/storage') ? 'YES' : 'NO') . "<br>";
    echo "Log Writable: " . (is_writable(__DIR__.'/storage/logs/laravel.log') ? 'YES' : 'NO') . "<br>";
    echo "Views Writable: " . (is_writable(__DIR__.'/storage/framework/views') ? 'YES' : 'NO') . "<br>";
}
