<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ClearSiteCache
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Setiap simpan/ubah/hapus di admin: buang cache agar website langsung up-to-date
        if (! $request->isMethod('GET')) {
            foreach (['home', 'sitemap', 'settings'] as $key) {
                Cache::forget($key);
            }
        }

        return $response;
    }
}