<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckLicense
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        if (!$user->hasActiveLicense()) {
            return redirect()->route('license.show')
                ->with('warning', 'Your license has expired or is not activated. Please enter a valid license key to continue.');
        }

        return $next($request);
    }
}
