<?php

namespace App\Http\Middleware;

use App;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->header('Accept-Language');

        if (!$locale) {
            $locale = config('app.locale'); // ja
        }

        if (in_array($locale, ['ja', 'en'])) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
