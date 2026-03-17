<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceHttps
{
    /**
     * 🔒 Security: إجبار استخدام HTTPS في الإنتاج
     */
    public function handle(Request $request, Closure $next): Response
    {
        // فقط في بيئة الإنتاج
        if (app()->environment('production')) {
            if (! $request->secure()) {
                return redirect()->secure($request->getRequestUri(), 301);
            }
        }

        return $next($request);
    }
}
