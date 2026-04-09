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
