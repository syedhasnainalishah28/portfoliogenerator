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
Route::get('/ha-secure-deploy/migrate', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        return "<div style='background:#f0fdf4; color:#166534; padding:20px; border-radius:8px; font-family:sans-serif;'>
                    <h1 style='margin-top:0;'>Migration Successful</h1>
                    <pre style='background:#ffffff; padding:10px; border:1px solid #dcfce7;'>" . \Illuminate\Support\Facades\Artisan::output() . "</pre>
                </div>";
    } catch (\Exception $e) {
        return "<div style='background:#fef2f2; color:#991b1b; padding:20px; border-radius:8px; font-family:sans-serif;'>
                    <h1 style='margin-top:0;'>Migration Failed</h1>
                    <pre style='background:#ffffff; padding:10px; border:1px solid #fee2e2;'>" . $e->getMessage() . "</pre>
                </div>";
    }
});

Route::get('/ha-secure-deploy/storage', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        return "<h1>Storage Link Created</h1>";
    } catch (\Exception $e) {
        return "<h1>Storage Link Error</h1><pre>" . $e->getMessage() . "</pre>";
    }
});

Route::get('/ha-secure-deploy/clear', function () {
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('route:clear');
    return "<h1>Cache Cleared Successfully</h1>";
});

require __DIR__.'/auth.php';
