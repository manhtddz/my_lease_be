<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\Auth\Authenticatable;
use Collective\Html\HtmlFacade as Html;
use Core\Helpers\Device;
use Core\Helpers\Url;
use Core\Providers\Facades\Storages\BaseStorage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Illuminate\Support\Facades\Session;

if (!function_exists('disableDebugBar')) {
    /**
     * disable debug bar
     */
    function disableDebugBar()
    {
        \Debugbar::disable();
    }
}

if (!function_exists('getConfig')) {
    /**
     * get config
     *
     * @param $key
     * @param null $default
     * @return mixed
     */
    function getConfig($key, $default = null): mixed
    {
        return config('config.' . $key, $default);
    }
}

if (!function_exists('getConstant')) {
    /**
     * get config constant
     *
     * @param $key
     * @param null $default
     * @return mixed
     */
    function getConstant($key, $default = null): mixed
    {
        return config('constant.' . $key, $default);
    }
}

if (!function_exists('getArea')) {
    /**
     * get current area
     * ex: batch, api, admin, web ...
     *
     * @return string|null
     */
    function getArea(): ?string
    {
        $area = 'web';

        if (App::runningInConsole()) {
            return 'batch';
        }

        if (request()->routeIs('livewire.*')) {
            return 'admin';
        }

        $requestUri = ltrim(urldecode(request()->getRequestUri()), '/\\');
        $config = getConfig('routes');

        foreach ($config as $key => $item) {
            $tmp = ltrim($item['prefix'], '/\\');
            if (mb_substr($requestUri, 0, mb_strlen($tmp)) == $tmp) {
                $area = $key;
                break;
            }
        }

        return $area;
    }
}

if (!function_exists('getGuard')) {
    /**
     * @return Guard|StatefulGuard
     */
    function getGuard(): Guard|StatefulGuard
    {
        $area = getArea();
        $guards = config('auth.guards');
        $guards = !empty($guards) ? array_keys($guards) : [];

        if (!empty($guards) && in_array($area, $guards)) {
            return Auth::guard($area);
        }

        // return default if guard not setting or not found
        return Auth::guard();
    }
}

if (!function_exists('getRoute')) {
    /**
     * get route with area
     *
     * @param null $route
     * @param array $parameters
     * @param bool $absolute
     * @return string
     */
    function getRoute($route = null, array $parameters = [], bool $absolute = true): string
    {
        $area = getArea();
        $as = 'web.';
        $config = getConfig('routes');
        foreach ($config as $key => $item) {
            if ($area == $key) {
                $as = $item['as'];
                break;
            }
        }

        if (empty($route)) {
            return route($as . 'home', $parameters, $absolute);
        }

        return route($as . $route, $parameters, $absolute);
    }
}

if (!function_exists('getControllerName')) {
    /**
     * get controller name
     *
     * @return string|null
     */
    function getControllerName(): ?string
    {
        if (empty(Route::getCurrentRoute())) {
            return '';
        }
        $name = Route::getCurrentRoute()->getActionName();
        $controller = explode('@', class_basename($name));
        $controller = reset($controller);
        if (empty($controller)) {
            return '';
        }
        $controller = str_replace(['controller', 'Controller'], '', $controller);
        return strtolower(preg_replace('/([^A-Z])([A-Z])/', "$1_$2", $controller));
    }
}

if (!function_exists('getActionName')) {
    /**
     * get method in controller
     *
     * @return string|null
     */
    function getActionName(): ?string
    {
        if (empty(Route::getCurrentRoute())) {
            return '';
        }
        $method = Route::getCurrentRoute()->getActionMethod();
        return strtolower(preg_replace('/([^A-Z])(A-Z)/', "$1_$2", $method));
    }
}

if (!function_exists('isEnableChatWork')) {
    /**
     * enable | disable push message to chatwork
     * support for write log errors, critical ...
     *
     * @return mixed
     */
    function isEnableChatWork(): mixed
    {
        return config('services.chat_work.is_enable', false);
    }
}


if (!function_exists('isEnableLogSql')) {
    /**
     * @return mixed
     */
    function isEnableLogSql(): mixed
    {
        return env('LOG_SQL', false);
    }
}

if (!function_exists('buildVersion')) {
    /**
     * @param $file
     * @return string
     */
    function buildVersion($file): string
    {
        return $file . '?v=' . getConfig('static_version', date('YmdHis'));
    }
}

if (!function_exists('toSql')) {
    /**
     * @param $query
     * @return string
     */
    function toSql($query): string
    {
        try {
            $sql = $query->toSql();
            $bindings = $query->getBindings();

            $boundSql = str_replace(['%', '?'], ['%%', '%s'], $sql);

            foreach ($bindings as &$binding) {
                if ($binding instanceof DateTime) {
                    $binding = $binding->format('\'Y-m-d H:i:s\'');
                } elseif (is_string($binding)) {
                    $binding = "'$binding'";
                }
            }

            return vsprintf($boundSql, $bindings);
        } catch (\Exception $exception) {
            logError($exception->getMessage() . PHP_EOL . $exception->getTraceAsString());
            return '';
        }
    }
}

if (!function_exists('logDebug')) {
    /**
     * @param $message
     * @param array $context
     * @param string $path
     */
    function logDebug($message, array $context = [], string $path = '')
    {
        Log::channel(config('logging.default'))->debug($message, array_merge($context, ['path' => $path]));
    }
}

if (!function_exists('logInfo')) {
    /**
     * @param $message
     * @param array $context
     * @param string $path
     */
    function logInfo($message, array $context = [], string $path = '')
    {
        Log::channel(config('logging.default'))->info($message, array_merge($context, ['path' => $path]));
    }
}

if (!function_exists('logNotice')) {
    /**
     * @param $message
     * @param array $context
     * @param string $path
     */
    function logNotice($message, array $context = [], string $path = '')
    {
        Log::channel(config('logging.default'))->notice($message, array_merge($context, ['path' => $path]));
    }
}

if (!function_exists('logWarning')) {
    /**
     * @param $message
     * @param array $context
     * @param string $path
     */
    function logWarning($message, array $context = [], string $path = '')
    {
        Log::channel(config('logging.default'))->warning($message, array_merge($context, ['path' => $path]));
    }
}

if (!function_exists('logError')) {
    /**
     * @param $message
     * @param array $context
     * @param string $path
     */
    function logError($message, array $context = [], string $path = '')
    {
        try {
            Log::channel(config('logging.default'))->error($message, array_merge($context, ['path' => $path]));
        } catch (Exception $e) {
            \Illuminate\Support\Facades\Log::error($e);
            echo $e->getMessage();
        }
    }
}

if (!function_exists('logCritical')) {
    /**
     * @param $message
     * @param array $context
     * @param string $path
     */
    function logCritical($message, array $context = [], string $path = '')
    {
        Log::channel(config('logging.default'))->critical($message, array_merge($context, ['path' => $path]));
    }
}

if (!function_exists('logAlert')) {
    /**
     * @param $message
     * @param array $context
     * @param string $path
     */
    function logAlert($message, array $context = [], string $path = '')
    {
        Log::channel(config('logging.default'))->alert($message, array_merge($context, ['path' => $path]));
    }
}

if (!function_exists('logEmergency')) {
    /**
     * @param $message
     * @param array $context
     * @param string $path
     */
    function logEmergency($message, array $context = [], string $path = '')
    {
        Log::channel(config('logging.default'))->emergency($message, array_merge($context, ['path' => $path]));
    }
}

if (!function_exists('getClientIp')) {
    /**
     * get Client IP Address
     *
     * @return mixed
     */
    function getClientIp(): mixed
    {
        return $_SERVER['HTTP_CLIENT_IP'] ?? $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['HTTP_X_FORWARDED'] ?? $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'] ?? $_SERVER['HTTP_FORWARDED_FOR'] ?? $_SERVER['HTTP_FORWARDED'] ?? $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
    }
}

if (!function_exists('getBodyClass')) {
    /**
     * body class
     *
     * @return string
     */
    function getBodyClass(): string
    {
        $area = getArea();
        $controllerName = getControllerName();
        $actionName = getActionName();
        $device = Device::getDevice();
        $os = Device::getOs();
        $browser = Device::getBrowser();

        return 'area-' . (empty($area) ? 'null' : $area)
            . ' c-' . (empty($controllerName) ? 'null' : $controllerName)
            . ' a-' . (empty($actionName) ? 'null' : $actionName)
            . ' device-' . (empty($device) ? 'unknown' : $device)
            . ' os-' . (empty($os) ? 'unknown' : $os)
            . ' browser-' . (empty($browser) ? 'unknown' : $browser);
    }
}

if (!function_exists('loadFiles')) {
    /**
     * load file .css, .js ...
     *
     * @param $files
     * @param string $area
     * @param string $type
     * @return string
     */
    function loadFiles($files, string $area = '', string $type = 'css'): string
    {
        if (empty($files)) {
            return '';
        }

        $result = '';

        foreach ($files as $item) {
            $filePath = str('assets')->append('/' . $type . (!empty($area) ? '/' . $area : '') . '/' . $item . '.' . $type);
            $result .= $type == 'css'
                ? Html::style(asset($filePath))
                : Html::script(asset($filePath));
        }

        return $result;
    }
}

if (!function_exists('public_url')) {
    /**
     * get public url
     *
     * @param $url
     * @return mixed
     */
    function public_url($url): mixed
    {
        if (str_contains($url, 'http')) {
            return $url;
        }

        $appURL = config('app.url');
        $str = substr($appURL, strlen($appURL) - 1, 1);

        if ($str != '/') {
            $appURL .= '/';
        }

        if (request()->isSecure()) {
            $appURL = str_replace('http://', 'https://', $appURL);
        }

        return $appURL . $url;
    }
}

if (!function_exists('getMediaDir')) {
    /**
     * get media dir
     *
     * @param $file
     * @return string
     */
    function getMediaDir($file = null): string
    {
        return getConfig('media_dir', 'media') . '/' . $file;
    }
}

if (!function_exists('getTmpUploadDir')) {
    /**
     * get tmp upload dir
     *
     * @param $file
     * @return string
     */
    function getTmpUploadDir($file = null): string
    {
        return getConfig('tmp_upload_dir', 'tmp_upload') . '/' . $file;
    }
}

if (!function_exists('baseStorageUrl')) {
    /**
     * @param $path
     * @return string
     */
    function baseStorageUrl($path): string
    {
        return BaseStorage::url($path);
    }
}

if (!function_exists('backUrl')) {
    /**
     * build back url
     *
     * @param $url
     * @param string $default
     * @param array $paramsDefault
     * @param array $params
     * @return UrlGenerator|string
     */
    function backUrl($url, array $params = [], string $default = '', array $paramsDefault = []): string|UrlGenerator
    {
        return Url::backUrl($url, $params, $default, $paramsDefault);
    }
}

if (!function_exists('keepBack')) {
    /**
     * @return string
     */
    function keepBack(): string
    {
        return Url::keepBackUrl();
    }
}

if (!function_exists('getBackUrl')) {
    /**
     * @param bool $fromConfirm
     * @param bool $fullUrl
     * @return mixed
     */
    function getBackUrl(bool $fromConfirm = false, bool $fullUrl = true): mixed
    {
        return $fromConfirm ? Url::getOldUrl() : Url::getBackUrl($fullUrl);
    }
}

if (!function_exists('getBackParams')) {
    /**
     * @param false $fromSession
     * @return mixed
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    function getBackParams(bool $fromSession = false): mixed
    {
        $r = request()->get(Url::QUERY);

        if ($fromSession) {
            $urlKeys = session(Url::URl_KEY, []);
            $url = $urlKeys[$r] ?? '';
            $parts = parse_url($url, PHP_URL_QUERY);
            parse_str($parts, $params);

            return data_get($params, Url::QUERY);
        }

        return $r;
    }
}

if (!function_exists('escape_like')) {
    /**
     * escape like
     *
     * @param string $value
     * @param string $char
     * @return string
     */
    function escape_like(string $value, string $char = '\\'): string
    {
        return str_replace(
            [$char, '%', '_'],
            [$char . $char, $char . '%', $char . '_'],
            $value
        );
    }
}

if (!function_exists('is_json')) {
    /**
     * check is json string
     *
     * @param $string
     * @return bool
     */
    function is_json($string): bool
    {
        try {
            json_decode($string);
            return json_last_error() === JSON_ERROR_NONE;
        } catch (\Exception $exception) {
            return false;
        }
    }
}

if (!function_exists('jsonEncode')) {
    /**
     * @param $data
     * @return false|string
     */
    function jsonEncode($data): bool|string
    {
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}

if (!function_exists('getLoginUser')) {
    /**
     * @param null $field
     * @return Authenticatable|null
     */
    function getLoginUser($field = null)
    {
        try {
            if (!getGuard()->check()) {
                return null;
            }

            return !empty($field) ? getGuard()->user()->{$field} : getGuard()->user();
        } catch (\Exception $exception) {
            // not write logs
            return null;
        }
    }
}

if (!function_exists('reqCode')) {
    function reqCode()
    {
        return request()->server('REQUEST_URI') .'_'. request()->server('REQUEST_TIME');
    }
}

if (!function_exists('checkMimeTypeImage')) {
    function checkMimeTypeImage($imageUrl)
    {
       if (!$imageUrl) return false;
        if ($imageUrl instanceof UploadedFile) {
            return Str::startsWith($imageUrl->getMimeType(), 'image/');
        }

        if (is_string($imageUrl) && File::exists($imageUrl)) {
            return Str::startsWith(File::mimeType($imageUrl), 'image/');
        }
        return false;
    }
}

if (!function_exists('getImageTag')) {
    function getImageTag($imageUrl)
    {
        return '<img src="' . $imageUrl . '" width="200" alt="Preview">';
    }
}

if (!function_exists('showImagePreview')) {
    function showImagePreview($imageUrl)
    {
        if (is_string($imageUrl)) {
                return getImageTag($imageUrl);
        }

        if (checkMimeTypeImage($imageUrl)) {
            return getImageTag($imageUrl->temporaryUrl());
        }
        return null;
    }

    if (!function_exists('checkArrayFilter')) {
        function checkArrayFilter($value)
        {
            if ($value === null || $value === '') {
                return false;
            }

            if (is_array($value) && empty($value)) {
                return false;
            }

            return true;
        }
    }
}


