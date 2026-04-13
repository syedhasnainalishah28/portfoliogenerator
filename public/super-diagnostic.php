<?php
// super-diagnostic.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$baseDir = __DIR__.'/../';

try {
    require $baseDir . 'vendor/autoload.php';
    $app = require_once $baseDir . 'bootstrap/app.php';
    
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    $response = $kernel->handle(
        $request = Illuminate\Http\Request::create('/', 'GET')
    );
    
    if ($response->getStatusCode() == 500) {
        echo "<h1>Route executed but returned 500. Laravel handled it smoothly though!</h1>";
        echo "<h3>Logs tail:</h3><pre>";
        echo htmlspecialchars(shell_exec('tail -n 50 ' . escapeshellarg($baseDir.'storage/logs/laravel.log')));
        echo "</pre>";
    } else {
        echo "<h1>SUCCESS 200</h1>";
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
}
