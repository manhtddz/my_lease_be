<?php

namespace App\Providers;

use App\Database\Migration\BlueprintCustom;
use App\Validators\Contracts\CustomValidatorContract;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Core\Providers\Facades\Schema\CustomBlueprint;
use Illuminate\Validation\DatabasePresenceVerifier;
use Illuminate\View\Compilers\BladeCompiler;
use Laravel\Sanctum\Sanctum;
use Validator;
use Illuminate\Validation\Factory;
use App\Validators\Contracts\CustomValidatorFactory;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // database
        $this->registerDatabase();

        // only HTTPs
        $this->ensureHttps();

        // custom storage
        $this->registerBaseStorage();

        // custom validate
        $this->registerValidation();

        $this->app->singleton('files', function () {
            return new Filesystem();
        });

        $this->app->singleton('blade.compiler', function ($app) {
        return new BladeCompiler(
            $app['files'],
            $app['config']['view.compiled']
        );
    });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // log SQL
        $this->logSql();

        // Configure rate limiting for API
        $this->configureRateLimiting();

        Sanctum::usePersonalAccessTokenModel(\Laravel\Sanctum\PersonalAccessToken::class);
    }

    /**
     * Configure rate limiting
     */
    protected function configureRateLimiting(): void
    {
        \Illuminate\Support\Facades\RateLimiter::for('api', function (\Illuminate\Http\Request $request) {
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(200)->by($request->user()?->id ?: $request->ip());
        });
    }

    protected function registerDatabase()
    {
        // custom connector
        $this->app->bind('db.connector.mysql', 'Core\Database\Connectors\BaseMySqlConnector');
        $this->app->bind('db.connector.pgsql', 'Core\Database\Connectors\BasePostgresConnector');
        $this->app->bind('db.connector.sqlite', 'Core\Database\Connectors\BaseSQLiteConnector');
        $this->app->bind('db.connector.sqlsrv', 'Core\Database\Connectors\BaseSqlServerConnector');

        // custom schema
        $this->app->bind('db.custom.schema', function ($app) {
            $schema = $app['db']->connection()->getSchemaBuilder();
            $schema->blueprintResolver(function ($table, $callback) {
                return new BlueprintCustom($table, $callback);
            });
            return $schema;
        });
    }

    /**
     * set Https only
     */
    protected function ensureHttps()
    {
        if (config('app.https')) {
            url()->forceScheme('https');
            $this->app['request']->server->set('HTTPS', true);
        }
    }

    /**
     * register base storage
     */
    protected function registerBaseStorage()
    {
        $this->app->bind('basestorage', 'Core\Providers\Facades\Storages\NewStorage');
    }

    /**
     * log SQL
     */
    protected function logSql()
    {
        if (!isEnableLogSql()) {
            return;
        }

        try {
            // clear _reqCode
            if (session()->has('_reqCode')){
                session()->forget('_reqCode');
            }

            DB::listen(function ($sql) {
                $isJobs = str_contains($sql->sql, 'jobs') || str_contains($sql->sql, 'failed_jobs');
                if (App::runningInConsole() && $isJobs) {
                    return;
                }

                foreach ($sql->bindings as $i => $binding) {
                    if ($binding instanceof \DateTime) {
                        $sql->bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
                    } else {
                        if (is_string($binding)) {
                            $sql->bindings[$i] = "'$binding'";
                        }
                    }
                }

                // Insert bindings into query
                $query = str_replace(array('%', '?'), array('%%', '%s'), $sql->sql);
                $query = vsprintf($query, $sql->bindings);

                // write log
                $time = sprintf('%05.2f', $sql->time);
                $log = "(Time: {$time}) SQL: {$query}";
                logDebug($log, [], getArea() .'.'. getConfig('logs.sql_log_filename'));

                // make _reqCode for group sql in logDebug
                session()->put('_reqCode', reqCode());
            });
        } catch (\Exception $exception) {
            // write log errors
            Log::error($exception);
        }
    }

    protected function registerValidation()
    {
        $this->app->extend(Factory::class, function ($factory, $app) {
            $customFactory = new CustomValidatorFactory(
                $factory->getTranslator(),
                $app
            );

            $customFactory->setPresenceVerifier(
                $app->make(DatabasePresenceVerifier::class)
            );

            return $customFactory;
        });
    }
}
