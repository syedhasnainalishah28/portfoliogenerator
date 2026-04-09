<?php

use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\PortfolioDownloadController;
use App\Http\Controllers\PortfolioIndexController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $user = request()->user();
    return view('dashboard', [
        'portfolioCount' => $user->portfolios()->count(),
        'latestPortfolios' => $user->portfolios()->latest()->take(5)->get(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/generator', function () {
        return view('app');
    })->name('generator');

    Route::post('/api/portfolios', [PortfolioController::class, 'store'])
        ->middleware('throttle:20,1')
        ->name('portfolios.store');
    Route::get('/api/portfolios/{portfolio}/download', [PortfolioDownloadController::class, 'download'])
        ->middleware('throttle:20,1')
        ->name('portfolios.download');
    Route::get('/portfolios', [PortfolioIndexController::class, 'index'])->name('portfolios.index');

    Route::get('/api/templates/{key}/fields', function ($key) {
        $path = resource_path("templates/{$key}/fields.json");
        if (file_exists($path)) {
            return response()->file($path);
        }
        return response()->json(['error' => 'Not found'], 404);
    })->name('templates.fields');

    Route::get('/templates/{key}/preview', function ($key) {
        $htmlPath = resource_path("templates/{$key}/index.html");
        
        if (file_exists($htmlPath)) {
            // For a basic GET preview, just build placeholders with empty user data (so it uses fields.json defaults)
            $placeholders = \App\Helpers\TemplateHelper::buildPlaceholders($key, []);
            
            $content = file_get_contents($htmlPath);
            foreach ($placeholders as $ph => $val) {
                $content = str_replace("[[{$ph}]]", $val, $content);
            }
            
            // Inject morphdom into the basic preview so we can update it seamlessly
            $morphdomScript = '<script src="https://unpkg.com/morphdom@2.7.4/dist/morphdom-umd.js"></script>
            <script>
                window.addEventListener("message", function(e) {
                    if (e.data && e.data.html) {
                        morphdom(document.documentElement, e.data.html, {
                            onBeforeElUpdated: function(fromEl, toEl) {
                                if (fromEl.tagName === "SCRIPT") return false;
                                return true;
                            }
                        });
                    }
                });
            </script>';
            $content = str_replace('</body>', $morphdomScript . '</body>', $content);
            
            return response($content)->header('Content-Type', 'text/html');
        }
        abort(404);
    })->name('templates.preview');

    Route::post('/templates/{key}/live-preview', function (\Illuminate\Http\Request $request, $key) {
        $htmlPath = resource_path("templates/{$key}/index.html");
        
        if (file_exists($htmlPath)) {
            $input = $request->json()->all() ?? [];
            $placeholders = \App\Helpers\TemplateHelper::buildPlaceholders($key, $input);
            
            $content = file_get_contents($htmlPath);
            foreach ($placeholders as $ph => $val) {
                $content = str_replace("[[{$ph}]]", $val, $content);
            }
            return response($content)->header('Content-Type', 'text/html');
        }
        abort(404);
    })->name('templates.live-preview');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Deployment routes for Terminal-less Shared Hosting
Route::get('/deploy/migrate', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        return "<h1>Migration Successful</h1><p>" . \Illuminate\Support\Facades\Artisan::output() . "</p>";
    } catch (\Exception $e) {
        return "<h1>Migration Failed</h1><pre>" . $e->getMessage() . "</pre>";
    }
});

Route::get('/deploy/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    return "<h1>Cache Cleared</h1>";
});

require __DIR__.'/auth.php';
