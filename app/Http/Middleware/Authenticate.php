<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string[]  ...$guards
     * @return mixed
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $isLivewire = request()->routeIs('livewire.*');

        if ($isLivewire) {
            return $next($request);
        }

        // Gọi parent handle để thực hiện authentication logic chuẩn của Laravel
        // Parent sẽ tự động kiểm tra guards và gọi unauthenticated() nếu không authenticated
        return parent::handle($request, $next, ...$guards);
    }

    /**
     * Handle unauthenticated users.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  array  $guards
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function unauthenticated($request, array $guards)
    {
        $area = getArea();

        // API (theo prefix config) hoặc Sanctum → trả 401 JSON qua AuthenticationException
        $isApiRequest = $area === 'api'
            || in_array('sanctum', $guards, true);

        $wantsJson = $isApiRequest
            || ($request->expectsJson() && $request->ajax() && $request->wantsJson());

        if ($wantsJson) {
            throw new AuthenticationException(
                __('messages.not_permission') ?: 'Unauthenticated.',
                $guards,
                null,
            );
        }

        throw new AuthenticationException(
            __('messages.not_permission') ?: 'Unauthenticated.',
            $guards,
            route(($area ?: 'web') . '.login'),
        );
    }
}
