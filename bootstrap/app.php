<?php

use App\Enums\ApiStatusEnum;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        // api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',

        then: function () {
            // Lấy cấu hình route
            $config = getConfig('routes');

            foreach ($config as $area => $item) {
                Route::prefix($item['prefix'] ?? '')
                    ->middleware($item['middleware'] ?? [])
                    ->namespace('App\\Http\\Controllers' . ($item['namespace'] ?? ''))
                    ->group(base_path("routes/{$area}.php"));
            }
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->append([
            \App\Http\Middleware\TrustProxies::class,
            \Illuminate\Http\Middleware\HandleCors::class,
            \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
            \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
            \App\Http\Middleware\TrimStrings::class,
            \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        ]);
        $middleware->group('admin', [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        $middleware->group('web', [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ]);

        $middleware->group('api', [
            \Illuminate\Routing\Middleware\ThrottleRequests::class.':api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \App\Http\Middleware\SetLocale::class,
        ]);

        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
            'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
            'auth.session' => \Illuminate\Session\Middleware\AuthenticateSession::class,
            'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
            'can' => \Illuminate\Auth\Middleware\Authorize::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
            'signed' => \App\Http\Middleware\ValidateSignature::class,
            'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
            'locale' => \App\Http\Middleware\Locale::class,
            'auth.api' => \App\Http\Middleware\AuthAPI::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        /*
        |--------------------------------------------------------------------------
        | API / JSON: AuthenticationException must not fall back to route('login').
        | Handler uses route('login') when !shouldReturnJson && no redirect URL.
        |--------------------------------------------------------------------------
        */
        $exceptions->shouldRenderJsonWhen(function (\Illuminate\Http\Request $request, \Throwable $e) {
            return getArea() === 'api' || $request->expectsJson();
        });

        /*
        |--------------------------------------------------------------------------
        | REPORT (thay cho report())
        |--------------------------------------------------------------------------
        */
        $exceptions->report(function (\Throwable $e) {
            try {
                $message = str(
                    $e->getMessage() . PHP_EOL . $e->getTraceAsString()
                )->append(
                    '","[F]' . $e->getFile() . '",[L]' . $e->getLine()
                );

                logError($message);
            } catch (\Throwable $ex) {
                logError($ex->getMessage() . PHP_EOL . $ex->getTraceAsString());
                throw $ex;
            }
        });

        /*
        |--------------------------------------------------------------------------
        | CSRF TokenMismatch (thay cho render())
        |--------------------------------------------------------------------------
        */
        $exceptions->render(function (\Throwable $e, Request $request) {
            if (!$e instanceof TokenMismatchException) {
                return null;
            }

            if ($request->ajax()) {
                return response()->json([
                    'status' => false,
                    'message' => __('messages.token_expiration'),
                    'data' => [
                        'token' => csrf_token(),
                        'email' => __('messages.token_expiration')
                    ]
                ]);
            }

            return redirect(getRoute('login'))
                ->with(['token_expiration' => __('messages.token_expiration')])
                ->withInput($request->except('_token'));
        });

        /*
        |--------------------------------------------------------------------------
        | HTTP Exception (thay cho renderHttpException)
        |--------------------------------------------------------------------------
        */
        $exceptions->render(function (\Throwable $e, Request $request) {
            if (!$e instanceof HttpExceptionInterface) {
                return null;
            }

            logError($e);

            $area = getArea();
            $status = $e->getStatusCode();

            if ($area === 'api') {
                $code = match (true) {
                    $e instanceof NotFoundHttpException => Response::HTTP_NOT_FOUND,
                    $e instanceof MethodNotAllowedHttpException => Response::HTTP_METHOD_NOT_ALLOWED,
                    default => Response::HTTP_INTERNAL_SERVER_ERROR,
                };

                return response()->json([
                    'status' => ApiStatusEnum::ERROR,
                    'message' => data_get(__('messages.http_code'), $code, $e->getMessage()),
                    'data' => [],
                ]);
            }

            if (view()->exists("{$area}.errors.{$status}")) {
                return response()->view("{$area}.errors.{$status}", [
                    'exception' => $e,
                    'area' => $area,
                    'title' => __('messages.page_title.errors'),
                ]);
            }

            return null; // fallback xuống handler tiếp theo
        });

        /*
        |--------------------------------------------------------------------------
        | FALLBACK (thay cho convertExceptionToResponse)
        |--------------------------------------------------------------------------
        */
        // $exceptions->render(function (\Throwable $e, Request $request) {

        //     $area = getArea();

        //     if (config('app.debug') && $area !== 'api') {
        //         return null; // Laravel default
        //     }

        //     $msg = match (true) {
        //         $e instanceof \PDOException => __('messages.db_not_connect'),
        //         default => __('messages.system_error'),
        //     };

        //     if ($area === 'api') {
        //         return response()->json([
        //             'status' => ApiStatusEnum::ERROR,
        //             'message' => $msg,
        //             'data' => [],
        //         ]);
        //     }

        //     if (view()->exists("{$area}.errors.500")) {
        //         return response()->view("{$area}.errors.500", [
        //             'exception' => $e,
        //             'area' => $area,
        //             'title' => __('messages.page_title.errors'),
        //         ]);
        //     }

        //     return null;
        // });
    })->create();
