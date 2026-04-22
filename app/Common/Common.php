<?php

use App\Enums\LanguageEnum;
use App\Enums\PropertyBpTypeEnum;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use chillerlan\QRCode\{QRCode, QROptions};

//use \App\Helpers\Facades\ChannelLog;


if (!function_exists('hasRoute')) {
    /**
     * @param string $route
     * @return bool
     */
    function hasRoute(string $route = ''): bool
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

        return \Illuminate\Support\Facades\Route::has($as . $route);
    }
}
if (!function_exists('loadFiles2')) {
    /**
     * load file .css, .js ...
     *
     * @param $files
     * @param string $area
     * @param string $type
     * @return string
     */
    function loadFiles2($files, string $area = '', string $type = 'css'): string
    {
        if (empty($files)) {
            return '';
        }

        $result = '';

        foreach ($files as $item) {
            $filePath = str('assets')->append((!empty($area) ? '/' . $area : '') . '/' . $item . '.' . $type);
            $result .= $type == 'css'
                ? Html::style(asset($filePath))
                : Html::script(asset($filePath));
        }

        return $result;
    }
}


#
if (!function_exists('getConstant')) {
    function getConstant($key, $default = null)
    {
        return config('constant.' . $key, $default);
    }
}
if (!function_exists('getConfig')) {
    /**
     * @param $key
     * @param null $default
     * @param $flip
     * @return array|\Illuminate\Config\Repository|mixed
     */
    function getConfig($key, $default = null, $flip = false)
    {
        $r = config('config.' . $key, $default);
        return is_array($r) && $flip ? array_flip($r) : $r;
    }
}

if (!function_exists('getConfigMail')) {
    function getConfigMail($key, $default = null, $flip = false)
    {
        $r = config('mail.'. $key, $default);
        return is_array($r) && $flip ? array_flip($r) : $r;
    }
}

if (!function_exists('getKeysConfig')) {

    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    function getKeysConfig($key, $default = null)
    {
        return array_keys(getConfig($key, $default));
    }
}
if (!function_exists('getSystemConfig')) {

    /**
     * @param $key
     * @param null $default
     * @param $flip
     * @return mixed
     */
    function getSystemConfig($key, $default = null, $flip = false)
    {
        return config('system.' . $key, $default, $flip);
    }
}

if (!function_exists('getTmpUploadUrl')) {

    /**
     * @param $file
     * @return mixed
     */
    function getTmpUploadUrl($file = null)
    {
        return asset(getTmpUploadDir($file));
    }
}
if (!function_exists('getTmpUploadPath')) {

    /**
     * @param $file
     * @return mixed
     */
    function getTmpUploadPath($file = null)
    {
        return public_path(getTmpUploadDir($file));
    }
}

if (!function_exists('getMediaUrl')) {

    /**
     * @param $file
     * @return mixed
     */
    function getMediaUrl($file = null)
    {
        return asset(getMediaDir($file));
    }
}
if (!function_exists('getMediaPath')) {

    /**
     * @param $file
     * @return mixed
     */
    function getMediaPath($file = null)
    {
        return public_path(getMediaDir($file));
    }
}
if (!function_exists('removeDirAndFiles')) {
    /**
     * Delete directory with files in it
     * @param $dir
     * @param bool $isCallback (important: must be 'false' when calling this function)
     * @return bool
     */
    function removeDirAndFiles($dir, $isCallback = false)
    {
        // validate
        $allowRemove = [
            getMediaPath(),
            public_path('excel'),
        ];
        $dir = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $dir);
        $realPath = $isCallback ? $dir : realpath($dir);
        foreach ($allowRemove as $item) {
            if ($realPath && strpos($realPath, $item) === 0) {
                // Delete directory with files in it
                foreach (glob($realPath) as $file) {
                    if (is_dir($file)) {
                        removeDirAndFiles($file . DIRECTORY_SEPARATOR . '*', true);
                        rmdir($file);
                    } else {
                        unlink($file);
                    }
                }
                return true;
            }
        }
        return false;
    }
}


// # route area
if (!function_exists('getAdminPrefix')) {
    function getAdminPrefix()
    {
        return getConfig('routes.admin.prefix');
    }
}

if (!function_exists('getWebPrefix')) {
    function getWebPrefix()
    {
        return getConfig('routes.web.prefix');
    }
}

if (!function_exists('getApiPrefix')) {
    function getApiPrefix()
    {
        return getConfig('routes.api.prefix');
    }
}

if (!function_exists('removeParamFromUrl')) {
    function removeParamFromUrl(&$url, $remove)
    {
        $part = explode('?', $url);
        $params = data_get($part, 1);
        if ($params) {
            $paramsArr = explode('&', $params);
            foreach ($paramsArr as $k => $p) {
                if (strpos($p, $remove . '=') === 0) {
                    unset($paramsArr[$k]);
                }
            }
            $params = implode('&', $paramsArr);
            $url = $part[0] . '?' . $params;
        }
    }
}

if (!function_exists('isUrl')) {
    function isUrl($url, $allowsAbbreviation = false)
    {
        if ($allowsAbbreviation) {
            // if allows abbreviation => 'https://*.com' is valid url
            $url = str_replace('*', 'fake', $url);
        }
        $url = trim($url);
        // requires $url to begin with 'http' || 'https' || 'www.'
        if (strpos($url, 'http') !== 0 && strpos($url, 'www.') !== 0) {
            return false;
        }
        $pattern = '/((([A-Za-z]{3,9}:(?:\/\/)?)(?:[-;:&=\+\$,\w]+@)?[A-Za-z0-9.-]+|(?:www.|[-;:&=\+\$,\w]+@)[A-Za-z0-9.-]+)((?:\/[\+~%\/.\w-_]*)?\??(?:[-\+=&;%@.\w_]*)#?(?:[\w]*))?)/';
        return preg_match($pattern, $url) ? true : false;
    }
}

// trans
if (!function_exists('trans2')) {
    function trans2($id = null, $replace = [], $locale = null)
    {
        return trans('trans2.' . $id, $replace, $locale);
    }
}
if (!function_exists('transm')) {

    /**
     * @param null $id
     * @param array $replace
     * @param null $locale
     * @return array|\Illuminate\Contracts\Translation\Translator|null|string
     */
    function transm($id = null, $replace = [], $locale = null)
    {
        return trans('models.' . $id, $replace, $locale);
    }
}

if (!function_exists('transma')) {

    /**
     * @param $modelName
     * @param null $id
     * @param array $replace
     * @param null $locale
     * @return array|\Illuminate\Contracts\Translation\Translator|null|string
     */
    function transma($modelName, $replace = [], $locale = null)
    {
        return transm($modelName . '.attributes', $replace, $locale);
    }
}

if (!function_exists('transa')) {

    /**
     * @param $modelName
     * @param null $id
     * @param array $replace
     * @param null $locale
     * @return array|\Illuminate\Contracts\Translation\Translator|null|string
     */
    function transa($modelName, $id = null, $replace = [], $locale = null)
    {
        return transm($modelName . '.attributes.' . $id, $replace, $locale);
    }
}


if (!function_exists('transv')) {
    /**
     * @param null $id
     * @param array $replace
     * @param null $locale
     * @return array|\Illuminate\Contracts\Translation\Translator|null|string
     */
    function transv($id = null, $replace = [], $locale = null)
    {
        return trans('validation.' . $id, $replace, $locale);
    }
}

if (!function_exists('tf')) {

    /**
     * translate web
     * @param null $id
     * @param array $replace
     * @param null $locale
     * @return array|\Illuminate\Contracts\Translation\Translator|null|string
     */
    function tf($id = null, $replace = [], $locale = null)
    {
        return transWithEditor('web.' . $id, $replace, $locale);
    }
}

if (!function_exists('tb')) {

    /**
     * translate backend
     * @param null $id
     * @param array $replace
     * @param null $locale
     * @return array|\Illuminate\Contracts\Translation\Translator|null|string
     */
    function tb($id = null, $replace = [], $locale = null)
    {
        return transWithEditor('backend.' . $id, $replace, $locale);
    }
}

if (!function_exists('transWithEditor')) {

    /**
     * translate web
     * @param null $id
     * @param array $replace
     * @param null $locale
     * @return array|\Illuminate\Contracts\Translation\Translator|null|string
     */
    function transWithEditor($id = null, $replace = [], $locale = null)
    {
        $r = trans($id, $replace, $locale);
        return getSystemConfig('trans_with_editor') ? '<span class="trans-with-editor" data-source="' . $id . '">' . $r . '</span>' : $r;
    }
}

// pagination
if (!function_exists('paginate')) {
    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    function paginate($key, $default = null)
    {
        return config('pagination.' . $key, $default);
    }
}

if (!function_exists('backendPaginate')) {
    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    function backendPaginate($key, $default = null)
    {
        return paginate('backend.' . $key, $default);
    }
}

if (!function_exists('webPaginate')) {
    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    function webPaginate($key, $default = null)
    {
        return paginate('web.' . $key, $default);
    }
}

if (!function_exists('apiPaginate')) {
    /**
     * @param $key
     * @param null $default
     * @return mixed
     */
    function apiPaginate($key, $default = null)
    {
        return paginate('api.' . $key, $default);
    }
}


// guard
if (!function_exists('adminGuard')) {
    function adminGuard()
    {
        return Auth::guard('admin');
    }
}
if (!function_exists('webGuard')) {
    function webGuard()
    {
        return Auth::guard('web');
    }
}
if (!function_exists('apiGuard')) {
    function apiGuard()
    {
        return Auth::guard('api');
    }
}


if (!function_exists('getCurrentUser')) {
    function getCurrentUser()
    {
        try {
            if (App::runningInConsole()) {
                //
            }
            if (webGuard()->user() && isWebArea()) {
                return webGuard()->user();
            }

            if (adminGuard()->user() && isAdminArea()) {
                return adminGuard()->user();
            }
            if (apiGuard()->user() && isApiArea()) {
                return apiGuard()->user();
            }

        } catch (\Exception $e) {
            logError($e);
        }
        return null;
    }
}

if (!function_exists('getCurrentUserId')) {
    /**
     * @param string $default
     * @return mixed
     */
    function getCurrentUserId($default = 0)
    {
        return data_get(getCurrentUser(), 'id', $default);
    }
}


if (!function_exists('getCurrentLangCode')) {

    /**
     * @param string $default
     * @return mixed
     */
    function getCurrentLangCode($default = 'ja')
    {
        try {
            return \Illuminate\Support\Facades\Session::get(getLocaleKey(), config('app.locale', $default));
        } catch (\Exception $e) {
            logError($e);
        } catch (\Error $error) {
            logError($error);
        }
        return config('app.locale', $default);
    }
}

function getLocaleKey()
{
    return match (true) {
        isAdminArea() => 'locale_admin',
        isWebArea() => 'locale_web',
        default => 'locale',
    };
}


// utils
if (!function_exists('toUnderScore')) {

    /**
     * @param $string
     * @return string
     */
    function toUnderScore($string)
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string));
    }
}

if (!function_exists('toCameCase')) {

    /**
     * @param $string
     * @return string
     */
    function toCameCase($string)
    {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $string))));
    }
}

if (!function_exists('isMulti')) {

    /**
     * @param $array
     * @return bool
     */
    function isMulti($array)
    {
        return (count($array) != count($array, 1));
    }
}

//breadcrumbs
if (!function_exists('breadcrumbConfirm')) {

    /**
     * @param $breadcrumbs
     * @param $screen
     * @param $subParent
     * @return mixed
     */
    function breadcrumbConfirm($breadcrumbs, $screen, $subParent = false)
    {
        $parent = $subParent ? 'create' : 'index';
        $keys = (array)getViewData('model')->getKeyName();
        $check = true;
        foreach ($keys as $key) {
            if (!request()->has($key)) {
                $check = false;
                break;
            }
        }
        if ($check) {
            $parent = $subParent ? 'edit' : $parent;
            $breadcrumbs->parent($screen . '.' . $parent);
            return $breadcrumbs->push(transb($screen . '.edit_confirm'));
        }
        $breadcrumbs->parent($screen . '.' . $parent);
        $breadcrumbs->push(transb($screen . '.create_confirm'));
    }
}
if (!function_exists('breadcrumbOther')) {

    /**
     * @param $breadcrumbs
     * @param $screen
     * @param null $parent
     * @param $allowLink
     * @param $params
     */
    function breadcrumbOther($breadcrumbs, $name, $parent = null, $allowLink = true, $params = [])
    {
        $parent ? $breadcrumbs->parent($parent) : null;
        $breadcrumbs->push(transb($name), $allowLink ? route($name, $params) : null, ['allowLink' => $allowLink]);
    }
}
if (!function_exists('breadcrumbCreate')) {

    /**
     * @param $breadcrumbs
     * @param $screen
     */
    function breadcrumbCreate($breadcrumbs, $screen)
    {
        $breadcrumbs->parent($screen . '.index');
        $route = $screen . '.create';
        $breadcrumbs->push(transb($route), route($route));
    }
}

if (!function_exists('breadcrumbEdit')) {

    /**
     * @param $breadcrumbs
     * @param $screen
     */
    function breadcrumbEdit($breadcrumbs, $screen)
    {
        $breadcrumbs->parent($screen . '.index');
        $route = $screen . '.edit';
        $params = [];
        foreach ((array)getViewData('model')->getKeyName() as $key) {
            $params[] = request($key, 0);
        }
        $breadcrumbs->push(transb($route), route($route, $params));
    }
}

if (!function_exists('breadcrumbShow')) {

    /**
     * @param $breadcrumbs
     * @param $screen
     */
    function breadcrumbShow($breadcrumbs, $screen)
    {
        $breadcrumbs->parent($screen . '.index');
        $route = $screen . '.show';
        $breadcrumbs->push(transb($route), '');
    }
}
if (!function_exists('breadcrumbIndex')) {

    /**
     * @param $breadcrumbs
     * @param $screen
     * @param null $parent
     * @param $allowLink
     * @param $params
     */
    function breadcrumbIndex($breadcrumbs, $screen, $parent = null, $allowLink = true, $params = [])
    {
        $route = $screen . '.index';
        $parent ? $breadcrumbs->parent($parent) : null;
        $breadcrumbs->push(transb($route), $allowLink ? route($route, $params) : null, ['allowLink' => $allowLink]);
    }
}

// # default fields (migrate / soft delete / autofill timestamps / autofill ins_id upd_id / ..)
if (!function_exists('getUpdatedAtColumn')) {
    function getUpdatedAtColumn()
    {
        return getConfig('model_field.updated.at');
    }
}
if (!function_exists('getCreatedAtColumn')) {
    function getCreatedAtColumn()
    {
        return getConfig('model_field.created.at');
    }
}
if (!function_exists('getDeletedAtColumn')) {
    function getDeletedAtColumn()
    {
        return getConfig('model_field.deleted.at');
    }
}

if (!function_exists('getDeletedFlagColumn')) {
    function getDeletedFlagColumn()
    {
        return getConfig('model_field.deleted.flag');
    }
}

if (!function_exists('getDeletedFlagValue')) {
    function getDeletedFlagValue(bool $isDeleted = false)
    {
        return $isDeleted ? getConfig('deleted_flag.on') : getConfig('deleted_flag.off');
    }
}

if (!function_exists('getCreatedByColumn')) {
    function getCreatedByColumn()
    {
        return getConfig('model_field.created.by');
    }
}

if (!function_exists('getUpdatedByColumn')) {
    function getUpdatedByColumn()
    {
        return getConfig('model_field.updated.by');
    }
}

if (!function_exists('getDeletedByColumn')) {
    function getDeletedByColumn()
    {
        return getConfig('model_field.deleted.by');
    }
}

// # end default fields


// password
if (!function_exists('genPassword')) {

    function genPassword($value)
    {
        if ($value && Hash::needsRehash($value)) {
            return Hash::make($value);
        }
        return $value;
    }
}

if (!function_exists('isCollection')) {

    function isCollection($value)
    {
        return $value instanceof Illuminate\Support\Collection || $value instanceof Illuminate\Database\Eloquent\Collection;
    }
}

if (!function_exists('format')) {

    function format($date, $format = 'Y-m-d H:i:s')
    {
        try {
            if (!$date) {
                return $date;
            }
            return Carbon::createFromFormat('Y-m-d H:i:s', $date)->format($format);
        } catch (\Exception $e) {
            $date = date($format, strtotime($date));
        }
        return $date;
    }

}
if (!function_exists('formatPhone')) {

    function formatPhone($phone, $format = '$1-$2-$3')
    {
        $phone = preg_replace("/[^0-9]/", "", $phone);
        return preg_replace("/([0-9]{3})([0-9]{3})([0-9]{3,6})/", $format, $phone);
    }

}
if (!function_exists('formatZipCode')) {

    function formatZipCode($value, $format = '$1-$2')
    {
        $value = preg_replace("/[^0-9]/", "", $value);
        return preg_replace("/([0-9]{3})([0-9]{1,7})/", $format, $value);
    }

}


if (!function_exists('setLang')) {

    function setLang($lang = '')
    {
        $lang = $lang ? $lang : getCurrentLangCode();
        App::setLocale($lang);
        \Illuminate\Support\Facades\Session::put(getLocaleKey(), $lang);
    }
}

if (!function_exists('array_filter_null')) {

    function array_filter_null($array)
    {
        foreach ($array as $key => $value) {
            if ($value === null || $value === '') {
                unset($array[$key]);
            }
        }
        return $array;
    }
}


if (!function_exists('toPhoneNumber')) {

    /**
     * @param $phone
     * @return mixed
     */
    function toPhoneNumber($phone)
    {
        return preg_replace(array('*-*', '*\s*', '*\(*', '*\)*'), '', $phone);
    }
}

if (!function_exists('getModelAttributes')) {

    /**
     * @param $alias
     * @return mixed
     */
    function getModelAttributes($alias)
    {
        return \Illuminate\Support\Facades\Lang::get('models.' . $alias . '.attributes');
    }
}

if (!function_exists('getModelCustomAttributes')) {

    /**
     * @param $alias
     * @return mixed
     */
    function getModelCustomAttributes($alias)
    {
        return \Illuminate\Support\Facades\Lang::get('models.' . $alias . '.custom_attributes');
    }
}
if (!function_exists('getModelAttribute')) {

    /**
     * @param $model
     * @param $attr
     * @return mixed
     */
    function getModelAttribute($model, $attr)
    {
        return \Illuminate\Support\Facades\Lang::get('models.' . $model . '.attributes.' . $attr);
    }
}
if (!function_exists('numberFormat')) {

    function numberFormat($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        return !is_numeric($number) || empty($number) || '0' === (string)$number ? $number : number_format($number, $decimals, $decPoint, $thousandsSep);
    }
}

if (!function_exists('floatNumberFormat')) {
    function floatNumberFormat($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        return (float)substr(numberFormat($number, $decimals + 1, $decPoint, $thousandsSep), 0, $decimals + 1); // eg: 0.09 --> 0.0
    }
}
if (!function_exists('ebr')) {

    function ebr($html, $showWhiteSpace = false)
    {
        $string = nl2br(e($html));
        if (!$showWhiteSpace) {
            return $string;
        }
        $string = str_replace(' ', '&nbsp;', $string);
        return str_replace('　', '&nbsp;', $string);
    }
}
if (!function_exists('getAge')) {

    function getAge($birthday)
    {
        try {
            $birthday = Carbon::parse($birthday)->format('Y-m-d');
            list($year, $month, $day) = explode("-", $birthday);
            $yearDiff = date("Y") - $year;
            $monthDiff = date("m") - $month;
            $dayDiff = date("d") - $day;
            if ($monthDiff < 0) {
                $yearDiff--;
            } else if (($monthDiff == 0) && ($dayDiff < 0)) {
                $yearDiff--;
            }
            return $yearDiff;
        } catch (\Exception $exception) {

        }
        return 0;
    }
}
if (!function_exists('tryParse')) {

    function tryParse($input, $format = null, $default = false)
    {
        if (!is_string($input)) {
            return $default;
        }
        try {
            $input = trim($input);
            $input = str_replace('/', '-', $input);
            $input = str_replace('：', ':', $input);
            $input = preg_replace('/(。|\.|ー)/', '-', $input);// replace: 'ー' => '-', '.' => '-', '。 '=> '-'
            $dateTime = Carbon::parse($input);
            if ($format) {
                return $dateTime->format($format);
            }
            return $dateTime;
        } catch (\Exception $exception) {
        }

        return $default;
    }
}
if (!function_exists('vietnameseToLatin')) {

    function vietnameseToLatin($string, $slug = '-')
    {
        $vietnamese = ["à", "á", "ạ", "ả", "ã", "â", "ầ", "ấ", "ậ", "ẩ", "ẫ", "ă", "ằ", "ắ", "ặ", "ẳ", "ẵ", "è", "é", "ẹ", "ẻ", "ẽ", "ê", "ề", "ế", "ệ", "ể", "ễ", "ì", "í", "ị", "ỉ", "ĩ", "ò", "ó", "ọ", "ỏ", "õ", "ô", "ồ", "ố", "ộ", "ổ", "ỗ", "ơ", "ờ", "ớ", "ợ", "ở", "ỡ", "ù", "ú", "ụ", "ủ", "ũ", "ư", "ừ", "ứ", "ự", "ử", "ữ", "ỳ", "ý", "ỵ", "ỷ", "ỹ", "đ", "À", "Á", "Ạ", "Ả", "Ã", "Â", "Ầ", "Ấ", "Ậ", "Ẩ", "Ẫ", "Ă", "Ằ", "Ắ", "Ặ", "Ẳ", "Ẵ", "È", "É", "Ẹ", "Ẻ", "Ẽ", "Ê", "Ề", "Ế", "Ệ", "Ể", "Ễ", "Ì", "Í", "Ị", "Ỉ", "Ĩ", "Ò", "Ó", "Ọ", "Ỏ", "Õ", "Ô", "Ồ", "Ố", "Ộ", "Ổ", "Ỗ", "Ơ", "Ờ", "Ớ", "Ợ", "Ở", "Ỡ", "Ù", "Ú", "Ụ", "Ủ", "Ũ", "Ư", "Ừ", "Ứ", "Ự", "Ử", "Ữ", "Ỳ", "Ý", "Ỵ", "Ỷ", "Ỹ", "Đ"];

        $latin = ["a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "e", "i", "i", "i", "i", "i", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "u", "y", "y", "y", "y", "y", "d", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "A", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "E", "I", "I", "I", "I", "I", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "O", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "U", "Y", "Y", "Y", "Y", "Y", "D"];

        $string = trim(str_replace($vietnamese, $latin, $string));
        $string = strtolower(str_replace(' ', $slug, $string));
        return preg_replace('/[^A-Za-z0-9\-\']/', '', $string);
    }
}
if (!function_exists('is_multi_array')) {

    function is_multi_array($arr)
    {
        rsort($arr);
        return isset($arr[0]) && is_array($arr[0]);
    }
}
if (!function_exists('sql_binding')) {

    function sql_binding($sql, $bindings)
    {
        if (empty($bindings)) {
            return $sql;
        }

        $boundSql = str_replace(['%', '?'], ['%%', '%s'], $sql);
        foreach ($bindings as &$binding) {
            if ($binding instanceof \DateTime) {
                $binding = $binding->format('\'Y-m-d H:i:s\'');
            } elseif (is_string($binding)) {
                $binding = "'$binding'";
            }
        }
        $boundSql = vsprintf($boundSql, $bindings);
        return $boundSql;
    }
}
if (!function_exists('toSql')) {

    function toSql($query)
    {
        return sql_binding($query->toSql(), $query->getBindings());
    }
}
if (!function_exists('mysql_escape')) {
    function mysql_escape($inp)
    {
        if (is_array($inp)) return array_map(__METHOD__, $inp);

        if (!empty($inp) && is_string($inp)) {
            return str_replace(array('\\', "\0", "\n", "\r", "'", '"', "\x1a"), array('\\\\', '\\0', '\\n', '\\r', "\\'", '\\"', '\\Z'), $inp);
        }

        return $inp;
    }
}
if (!function_exists('breadcrumb_register')) {
    function breadcrumb_register($breadcrumbs, $parent = '', $reject = [])
    {
        foreach ($breadcrumbs as $breadcrumb) {
            if (in_array($breadcrumb['type'], $reject)) {
                continue;
            }
            if ($breadcrumb['type'] == 'resource') {
                build_resource_breadcrumbs($breadcrumb, $parent);
                continue;
            }
            $name = isset($breadcrumb['name']) ? $breadcrumb['name'] : $breadcrumb['screen'] . '.' . $breadcrumb['type'];
            call_user_func_array('Breadcrumbs::register', [$name, function ($bd) use ($breadcrumb, $parent) {
                $type = $breadcrumb['type'];
                switch ($type) {
                    case 'index' :
                        breadcrumbIndex($bd, $breadcrumb['screen'], $parent, isset($breadcrumb['allow_link']) ? $breadcrumb['allow_link'] : true, data_get($breadcrumb, 'params'));
                        break;
                    case 'edit' :
                        breadcrumbEdit($bd, $breadcrumb['screen']);
                        break;
                    case 'show' :
                        breadcrumbShow($bd, $breadcrumb['screen']);
                        break;
                    case 'create' :
                        breadcrumbCreate($bd, $breadcrumb['screen']);
                        break;
                    case 'confirm' :
                        breadcrumbConfirm($bd, $breadcrumb['screen']);
                        break;
                    case 'other' :
                        breadcrumbOther($bd, $breadcrumb['name'], $parent, isset($breadcrumb['allow_link']) ? $breadcrumb['allow_link'] : true, data_get($breadcrumb, 'params'));
                        break;
                }
            }]);
            if (isset($breadcrumb['childs'])) {
                breadcrumb_register($breadcrumb['childs'], $name);
            }
        }
    }
}
function build_resource_breadcrumbs($breadcrumb, $parent)
{
    if (data_get($breadcrumb, 'only', [])) {
        $newBreadcrumbs = [];
        foreach (data_get($breadcrumb, 'only', []) as $type) {
            $newBreadcrumbs[] = [
                'type' => $type,
                'screen' => $breadcrumb['screen'],
            ];
        }
    } else {
        $newBreadcrumbs = [
            [
                'type' => 'index',
                'screen' => $breadcrumb['screen'],
            ],
            [
                'type' => 'show',
                'screen' => $breadcrumb['screen'],
            ],
            [
                'type' => 'edit',
                'screen' => $breadcrumb['screen'],
            ],
            [
                'type' => 'create',
                'screen' => $breadcrumb['screen'],
            ],
            [
                'type' => 'confirm',
                'screen' => $breadcrumb['screen'],
            ],
        ];
    }
    breadcrumb_register($newBreadcrumbs, $parent, data_get($breadcrumb, 'reject', []));
}

if (!function_exists('randomString')) {
    function randomString($length = 10)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('isIndex')) {
    function isIndex()
    {
        if (App::runningInConsole()) {
            return false;
        }
        return request()->route()->getActionMethod() === 'index';
    }
}
if (!function_exists('isDestroy')) {
    function isDestroy()
    {
        if (App::runningInConsole()) {
            return false;
        }
        return request()->route()->getActionMethod() === 'destroy';
    }
}
if (!function_exists('isMassDestroy')) {
    function isMassDestroy()
    {
        if (App::runningInConsole()) {
            return false;
        }
        return request()->route()->getActionMethod() === 'massDestroy';
    }
}
if (!function_exists('isCreate')) {
    function isCreate()
    {
        if (App::runningInConsole()) {
            return false;
        }
        return request()->route()->getActionMethod() === 'create';
    }
}
if (!function_exists('isShow')) {
    function isShow()
    {
        if (App::runningInConsole()) {
            return false;
        }
        return request()->route()->getActionMethod() === 'show';
    }
}
if (!function_exists('isEdit')) {
    function isEdit()
    {
        if (App::runningInConsole()) {
            return false;
        }
        return request()->route()->getActionMethod() === 'edit';
    }
}
if (!function_exists('isValid')) {
    function isValid()
    {
        if (App::runningInConsole()) {
            return false;
        }
        return request()->route()->getActionMethod() === 'isValid';
    }
}
if (!function_exists('isConfirm')) {
    function isConfirm()
    {
        if (App::runningInConsole()) {
            return false;
        }
        return request()->route()->getActionMethod() === 'confirm';
    }
}
if (!function_exists('isUpdate')) {
    function isUpdate()
    {
        if (App::runningInConsole()) {
            return false;
        }
        return request()->route()->getActionMethod() === 'update';
    }
}
if (!function_exists('isStore')) {
    function isStore()
    {
        if (App::runningInConsole()) {
            return false;
        }
        return request()->route()->getActionMethod() === 'store';
    }
}
if (!function_exists('getViewData')) {
    function getViewData($key = null)
    {
        $controller = request()->route() ? request()->route()->getController() : null;
        if ($controller && !request()->routeIs('livewire.*')) {
            if (method_exists($controller, 'getViewData')) {
                return $controller->getViewData($key);
            }
        }
        return null;
    }
}
if (!function_exists('public_url')) {
    function public_url($url)
    {
        if (strpos($url, 'http') !== false) {
            return $url;
        }

        $appURL = config('app.url');
        $str = substr($appURL, strlen($appURL) - 1, 1);
        if ($str != '/') {
            $appURL .= '/';
        }
        if (\Illuminate\Support\Facades\Request::secure()) {
            $appURL = str_replace('http://', 'https://', $appURL);
        }
        return $appURL . 'public/' . $url;
    }
}

if (!function_exists('isAdminArea')) {
    function isAdminArea(): bool
    {
        return getCurrentArea() == 'admin';
    }
}

if (!function_exists('isApiArea')) {
    function isApiArea()
    {
        return getCurrentArea() == 'api';
    }
}

if (!function_exists('isWebArea')) {
    function isWebArea()
    {
        return getCurrentArea() == 'web';
    }
}

if (!function_exists('isBatchArea')) {
    function isBatchArea()
    {
        return getCurrentArea() == 'batch';
    }
}

if (!function_exists('getCurrentArea')) {
    function getCurrentArea()
    {
        return getArea();
    }
}
if (!function_exists('getCurrentControllerName')) {
    function getCurrentControllerName()
    {
        return getViewData('controllerName');
    }
}
if (!function_exists('getCurrentAction')) {
    function getCurrentAction()
    {
        return getViewData('actionName');
    }
}
if (!function_exists('getBodyClass')) {
    function getBodyClass()
    {
        $viewData = getViewData();
        $injectBodyClass = isset($viewData['injectBodyClass']) ? $viewData['injectBodyClass'] : '';
        return ' area-' . getCurrentArea() . ' c-' . getCurrentControllerName() . ' a-' . getCurrentAction() . ' l-' . getCurrentLangCode() . ' ' . $injectBodyClass;
    }
}
if (!function_exists('addParamToUrl')) {
    function addParamToUrl($url, $varName, $value = null)
    {
        if (is_array($varName)) {
            $value = http_build_query($varName);
        } else {
            $value = $varName . "=" . $value;
        }
        // is there already an ?
        if (strpos($url, "?")) {
            $url .= "&" . $value;
        } else {
            $url .= "?" . $value;
        }
        return $url;
    }
}

if (!function_exists('escape')) {
    /**
     * Escape HTML special characters in a string and allow new line.
     *
     * @param \Illuminate\Contracts\Support\Htmlable|string $value
     * @param bool $is_xhtml [optional]
     * @return string
     */
    function escape($value, $is_xhtml = null)
    {
        return nl2br(e($value), $is_xhtml);
    }
}

if (!function_exists('isVideo')) {
    /**
     * @param string $url
     * @param array $extensionVideos
     * @return boolean
     */
    function isVideo($url, $extensionVideos = [])
    {
        $extensionVideos = empty($extensionVideos) ? getConfig('file.default.video.ext') : $extensionVideos;
        $extension = preg_replace('/.*\.(\w+$)/', '$1', $url);
        if (collect($extensionVideos)->contains(strtolower($extension))) { // is video
            return true;
        } else { // is not video
            return false;
        }
    }
}

if (!function_exists('isBase64Img')) {
    function isBase64Img($str)
    {
        $imageParts = explode(";base64,", $str);
        $str = data_get($imageParts, 1, $str);

        if (base64_encode(base64_decode($str, true)) === $str) {
            return true;
        } else {
            return false;
        }
    }
}

if (!function_exists('isMobile')) {
    function isMobile()
    {
        if (array_key_exists('HTTP_USER_AGENT', $_SERVER)) {
            $userAgent = $_SERVER['HTTP_USER_AGENT'];
            return preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $userAgent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($userAgent, 0, 4));
        }
        return false;
    }
}


/**
 * @return boolean
 */
if (!function_exists('isDebug')) {
    function isDebug()
    {
        return config('app.debug');
    }
}

/**
 * @return boolean
 */
if (!function_exists('rjust')) {
    function rjust($string, $totalLength, $fillChar = ' ')
    {
        return str_pad($string, $totalLength, $fillChar, STR_PAD_RIGHT);
    }
}
/**
 * @return boolean
 */
if (!function_exists('ljust')) {
    function ljust($string, $totalLength, $fillChar = ' ')
    {
        return str_pad($string, $totalLength, $fillChar, STR_PAD_LEFT);
    }
}


if (!function_exists('isController')) {
    function isController($controllerName)
    {
        return getCurrentControllerName() == $controllerName;
    }
}
if (!function_exists('isAction')) {
    function isAction($actionName)
    {
        return getCurrentAction() == $actionName;
    }
}

if (!function_exists('getNavActiveClass')) {
    function getNavActiveClass($controllerName, $actionName = '')
    {
        if (empty($actionName)) {
            return isController($controllerName) ? ' active' : '';
        }
        return isController($controllerName) && isAction($actionName) ? ' active' : '';
    }
}
if (!function_exists('myEncrypt')) {
    function myEncrypt($string, $key)
    {
        $result = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keyChar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) + ord($keyChar));
            $result .= $char;
        }

        return base64_encode($result);
    }
}
if (!function_exists('myDecrypt')) {
    function myDecrypt($string, $key)
    {
        $result = '';
        $string = base64_decode($string);

        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keyChar = substr($key, ($i % strlen($key)) - 1, 1);
            $char = chr(ord($char) - ord($keyChar));
            $result .= $char;
        }

        return $result;
    }
}

if (!function_exists('isEmail')) {
    function isEmail($value)
    {
        $regex = "/(?:[a-z0-9!#$%&'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+\/=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/";
        return preg_match($regex, $value);
    }
}

if (!function_exists('getBrowser')) {
    /**
     * @param null $userAgent
     * @param boolean $isGetInfoIfAgentIsNull
     * @return array
     */
    function getBrowser($userAgent = null, $isGetInfoIfAgentIsNull = true)
    {
        if (empty($userAgent) && !$isGetInfoIfAgentIsNull) {
            return [
                'user_agent' => $userAgent,
                'browser_name' => '',
                'version' => '',
                'platform' => '',
                'pattern' => '',
            ];
        }

        $browserName = 'Unknown';
        $platform = 'Unknown';
        $version = '';
        $pattern = '';
        $userAgent = !empty($userAgent) ? $userAgent : $_SERVER['HTTP_USER_AGENT'];

        try {
            $isMobile = preg_match('/.*(Mobile|mobile).*/i', $userAgent);
            //First get the platform?
            if (preg_match('/linux/i', $userAgent)) {
                $platform = $isMobile ? 'Android' : 'Linux';
            } elseif (preg_match('/macintosh|mac os x/i', $userAgent)) {
                $platform = $isMobile ? 'iOS' : 'macOS';
            } elseif (preg_match('/windows|win32/i', $userAgent)) {
                $platform = $isMobile ? 'Windows Phone' : 'Windows';
            }

            // Next get the name of the useragent yes seperately and for good reason
            if (preg_match('/MSIE/i', $userAgent) && !preg_match('/Opera/i', $userAgent) || preg_match('/Trident/i', $userAgent)) {
                $browserName = 'Internet Explorer';
                $ub = "Internet Explorer";
            } elseif (preg_match('/Edge/i', $userAgent)) {
                $browserName = 'Microsoft Edge';
                $ub = "Microsoft Edge";
            } elseif (preg_match('/Firefox/i', $userAgent)) {
                $browserName = 'Mozilla Firefox';
                $ub = "Firefox";
            } elseif (preg_match('/Chrome/i', $userAgent)) {
                $browserName = 'Google Chrome';
                $ub = "Chrome";
            } elseif (preg_match('/Safari/i', $userAgent)) {
                $browserName = 'Apple Safari';
                $ub = "Safari";
            } elseif (preg_match('/Opera/i', $userAgent)) {
                $browserName = 'Opera';
                $ub = "Opera";
            } elseif (preg_match('/Netscape/i', $userAgent)) {
                $browserName = 'Netscape';
                $ub = "Netscape";
            }

            // finally get the correct version number
            $known = array('Version', $ub, 'other');
            $pattern = '#(?<browser>' . join('|', $known) . ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
            if (!preg_match_all($pattern, $userAgent, $matches)) {
                // we have no matching number just continue
            }

            // see how many we have
            $i = count($matches['browser']);
            if ($i != 1) {
                //we will have two since we are not using 'other' argument yet
                //see if version is before or after the name
                if (strripos($userAgent, "Version") < strripos($userAgent, $ub)) {
                    $version = $matches['version'][0];
                } else {
                    $version = $matches['version'][1];
                }
            } else {
                $version = $matches['version'][0];
            }

            // check if we have a number
            if ($version == null || $version == "") {
                $version = "?";
            }
        } catch (Exception $e) {
            logError($e);
        }

        return [
            'user_agent' => $userAgent,
            'browser_name' => $browserName,
            'version' => $version,
            'platform' => $platform,
            'pattern' => $pattern,
        ];
    }
}

if (!function_exists('getUserIp')) {
    /**
     * https://www.ipify.org/ -> Code Sample
     * @return false|string
     */
    function getUserIp()
    {
        $remoteAddr = !empty($_SERVER) ? data_get($_SERVER, 'REMOTE_ADDR') : '';
        try {
            $ip = file_get_contents('https://api.ipify.org');
            return $ip ? $ip : $remoteAddr;
        } catch (Exception $e) {
            logError($e);
        }
        return $remoteAddr;
    }
}



if (!function_exists('removeInvalidCharsAndConvertUtf8')) {
    /**
     * For import csv
     * @param $file
     * @param $out
     * @param $out2
     * @return bool
     */
    function removeInvalidCharsAndConvertUtf8($file, $out, $out2)
    {
        if (!is_file($file) || !filesize($file)) {
            return false;
        }

        if (is_file($out) || is_file($out2)) {
            return false;
        }

        $fn = fopen($file, "r");
        $line = 0;
        for ($i = 0; $i < 10; $i++) {
            $line .= fgets($fn);
        }
        fclose($fn);

        // If is windows, use "C:/Program Files/Git/usr/bin/iconv.exe"
        $iconv = isWindows() ? '"C:/Program Files/Git/usr/bin/iconv.exe"' : 'iconv';
        $encodings = array('SJIS', 'SHIFT-JIS', 'UTF-8');
        foreach ($encodings as $encoding) {
            if (mb_check_encoding($line, $encoding)) {
                exec($iconv . ' -f ' . $encoding . ' -t ' . $encoding . ' -c "' . $file . '" > "' . $out . '"');
                exec($iconv . ' -f ' . $encoding . ' -t ' . 'UTF-8' . ' -c "' . $out . '" > "' . $out2 . '"');
                break;
            }
        }
        if (!is_file($out) || !filesize($out) || !is_file($out2) || !filesize($out2)) {
            return false;
        }
        return true;
    }
}

if (!function_exists('isWindows')) {
    /**
     * @return bool
     */
    function isWindows()
    {
        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';
    }
}

if (!function_exists('allowFilePermission')) {
    /**
     * @param $urlFile
     */
    function allowFilePermission($urlFile)
    {
        if (isWindows()) {
            return;
        }
        exec('sudo chmod -R 777 ' . $urlFile);
    }
}

if (!function_exists('array_key_first')) {
    function array_key_first(array $arr)
    {
        foreach ($arr as $key => $unused) {
            return $key;
        }
        return NULL;
    }
}

/**
 * get full url ignore query string
 * ex: http://domain.jp/management/crm/2/edit?user_id=2&table_id=83&db_id=21&_o=15766335295
 * => result: http://domain.jp/management/crm/2/edit
 */
if (!function_exists('getUrlIgnoreQueryString')) {
    function getUrlIgnoreQueryString()
    {
        return strtok($_SERVER["REQUEST_URI"], '?');
    }
}
/**
 * generate string job id
 */
if (!function_exists('genJobId')) {
    function genJobId($prefix)
    {
        $time = date('Ymd_His');
        $sha1Random = sha1(uniqid('_', true));
        $jobId = $prefix . '_' . $time . '_' . $sha1Random;
        return $jobId;
    }
}

if (!function_exists('removeDate')) {
    /**
     * @param $fullDate : Y-m-d | Y/m/d
     * @return false|string: Y-m | Y/m
     */
    function removeDate($fullDate)
    {
        if (!is_string($fullDate) || !$fullDate || $fullDate === '0000-00-00' || $fullDate === '0000-00-00 00:00:00') {
            return '';
        }
        if ($fullDate === '--01') {
            return '';
        }
        try {
            $separator = '/';
            if (strpos($fullDate, '-') !== false) {
                $separator = '-';
            }
            $fullDate = explode($separator, $fullDate);
            array_pop($fullDate);
            return implode($separator, $fullDate);
        } catch (\Exception $e) {

        }
        return '';
    }
}

if (!function_exists('addDate')) {
    /**
     * @param $yearAndMonth : Y-m | Y/m
     * @return string: Y-m-d | Y/m/d
     */
    function addDate($yearAndMonth)
    {
        if (!is_string($yearAndMonth) || !$yearAndMonth) {
            return '';
        }
        $separator = '/';
        if (strpos($yearAndMonth, '-') !== false) {
            $separator = '-';
        }
        $date = $yearAndMonth === "0000{$separator}00" ? '00' : '01';
        return $yearAndMonth . $separator . $date;
    }
}

if (!function_exists('milliseconds')) {
    function milliseconds()
    {
        return (int)round(microtime(true) * 1000);
    }
}

if (!function_exists('endWith')) {
    function endWith($haystack, $needle)
    {
        $length = strlen($needle);
        if ($length == 0) {
            return true;
        }
        return (substr($haystack, -$length) === $needle);
    }
}


if (!function_exists('prefixServerType')) {
    function prefixServerType($upper = true)
    {
        $serverType = getConstant('SERVER_TYPE');
        $serverType = $upper ? strtoupper($serverType) : $serverType;
        return '【' . $serverType . '】';
    }
}


if (!function_exists('convertToCRLF')) {
    function convertToCRLF($string)
    {
        if (is_array($string)) {
            foreach ($string as $index => $str) {
                $string[$index] = convertToCRLF($str);
            }

            return $string;
        }

        if (!(strpos($string, "\r") !== false) && !(strpos($string, "\n") !== false)) {
            return $string;
        }

        $tempWord = "___CRLF___";
        //find \r\n and replace to temporary word to mark them. So they will not be replaced in the next step
        $string = str_replace("\r\n", $tempWord, $string);

        //replace \r that being alone
        $string = str_replace("\r", $tempWord, $string);

        //replace \n that being alone
        $string = str_replace("\n", $tempWord, $string);

        return str_replace($tempWord, "\r\n", $string);
    }
}

if (!function_exists('logQueryToDebugbar')) {
    function logQueryToDebugbar($query, $connection)
    {
        if (isDebug()) { // add this query into debugbar
            $connection = !empty($connection) ? $connection : DB::connection();
            debugbar()->getCollector('queries')->addQuery((string)$query, [], null, $connection);
        }
    }
}

if (!function_exists('str_lreplace')) {
    function str_lreplace($search, $replace, $subject)
    {
        $pos = strrpos($subject, $search);
        if ($pos !== false) {
            $subject = substr_replace($subject, $replace, $pos, strlen($search));
        }
        return $subject;
    }
}


if (!function_exists('isIosSafari')) {
    function isIosSafari()
    {
        $browserAsString = $_SERVER['HTTP_USER_AGENT'];
        $isIosSafari = strstr($browserAsString, " AppleWebKit/") && strstr($browserAsString, " Mobile/");
        if ($isIosSafari) {
            return true;
        }
        return false;
    }
}

if (!function_exists('filter_arr_condition')) {
    function filter_arr_condition($array, $key, $conditions = [])
    {
        $sumArray = [];
        if (empty($array) || empty($conditions) || empty($key)) {
            return $array;
        }
        foreach ($array as $keyArray => $value) {
            $flag = true;
            foreach ($conditions as $keyC => $condition) {
                if ($value[$keyC] !== (string)$condition) {
                    $flag = false;
                    break;
                }
            }

            if ($flag) {
                $sumArray[$keyArray] = $value;
            }
        }
        return array_column($sumArray, $key);
    }
}


if (!function_exists('cNow')) {
    function cNow($tz = null)
    {
        return Carbon::now($tz);
    }
}

if (!function_exists('cParse')) {
    function cParse($time = null, $tz = null)
    {
        return Carbon::parse($time, $tz);
    }
}

if (!function_exists('cFormat')) {
    function cFormat($format = 'Y-m-d H:i:s', $time = null, $tz = null)
    {
        return cParse($time, $tz)->format($format);
    }
}


if (!function_exists('formatDateJapan')) {
    function formatDateJapan($date, string $format = 'Ymd')
    {
        if (empty($date)) {
            return '';
        }

        $listFormat = [
            'Y' => 'Y' . trans2('year'),
            'y' => 'y' . trans2('year'),
            'M' => 'M' . trans2('month'),
            'm' => 'm' . trans2('month'),
            'D' => 'D' . trans2('day'),
            'd' => 'd' . trans2('day'),
        ];
        $arrTypeSplit = str_split($format);
        $formatStr = '';

        foreach ($arrTypeSplit as $item) {
            $formatStr .= $listFormat[$item];
        }

        $result = Carbon::parse($date)->format($formatStr);

        return getCurrentLangCode() != LanguageEnum::JA ? rtrim($result, '/') : $result;
    }

}

if (!function_exists('makeSemiWidth')) {
    /**
     * @param $str
     * @return string
     * convert fullwith (Japanese) to halfwidth (English): Ex: ０１２３４５６７８９ => 0123456789
     */
    function makeSemiWidth($str)
    {
        $arr = array('０' => '0',
            '１' => '1',
            '２' => '2',
            '３' => '3',
            '４' => '4',
            '５' => '5',
            '６' => '6',
            '７' => '7',
            '８' => '8',
            '９' => '9',
            'Ａ' => 'A',
            'Ｂ' => 'B',
            'Ｃ' => 'C',
            'Ｄ' => 'D',
            'Ｅ' => 'E',
            'Ｆ' => 'F',
            'Ｇ' => 'G',
            'Ｈ' => 'H',
            'Ｉ' => 'I',
            'Ｊ' => 'J',
            'Ｋ' => 'K',
            'Ｌ' => 'L',
            'Ｍ' => 'M',
            'Ｎ' => 'N',
            'Ｏ' => 'O',
            'Ｐ' => 'P',
            'Ｑ' => 'Q',
            'Ｒ' => 'R',
            'Ｓ' => 'S',
            'Ｔ' => 'T',
            'Ｕ' => 'U',
            'Ｖ' => 'V',
            'Ｗ' => 'W',
            'Ｘ' => 'X',
            'Ｙ' => 'Y',
            'Ｚ' => 'Z',
            'ａ' => 'a',
            'ｂ' => 'b',
            'ｃ' => 'c',
            'ｄ' => 'd',
            'ｅ' => 'e',
            'ｆ' => 'f',
            'ｇ' => 'g',
            'ｈ' => 'h',
            'ｉ' => 'i',
            'ｊ' => 'j',
            'ｋ' => 'k',
            'ｌ' => 'l',
            'ｍ' => 'm',
            'ｎ' => 'n',
            'ｏ' => 'o',
            'ｐ' => 'p',
            'ｑ' => 'q',
            'ｒ' => 'r',
            'ｓ' => 's',
            'ｔ' => 't',
            'ｕ' => 'u',
            'ｖ' => 'v',
            'ｗ' => 'w',
            'ｘ' => 'x',
            'ｙ' => 'y',
            'ｚ' => 'z',
            '（' => '(',
            '）' => ')',
            '〔' => '[',
            '〕' => ']',
            '【' => '[',
            '】' => ']',
            '〖' => '[',
            '〗' => ']',
            '“' => '[',
            '”' => ']',
            '‘' => '[',
            '\'' => ']',
            '｛' => '{',
            '｝' => '}',
            '《' => '<',
            '》' => '>',
            '％' => '%',
            '＋' => '+',
            '—' => '-',
            'ー' => '-',
            '－' => '-',
            '～' => '-',
            '：' => ':',
            '。' => '.',
            '、' => ',',
            '，' => '.',
            '、' => '.',
            '；' => ',',
            '？' => '?',
            '！' => '!',
            '…' => '-',
            '‖' => '|',
            '”' => '"',
            '\'' => '`',
            '‘' => '`',
            '｜' => '|',
            '　' => ' ',
            '＠' => '@',
            '〃' => '"', '　
                 ' => ' ');
        return strtr($str, $arr);
    }
}

if (!function_exists('trimParams')) {
    function trimParams($params = [])
    {
        if (!empty($params) && is_array($params)) {
            $params = array_map(
                function ($item) {
                    return !is_array($item) ? trim(preg_replace("@[ 　]@u", ' ', $item)) : $item;
                },
                $params
            );
        }

        return $params;
    }
}

if (!function_exists('genViewId')) {
    function genViewId(string $prefix, $id)
    {
        return $prefix. '-' . str_pad($id, 7, '0', STR_PAD_LEFT);
    }
}

if (!function_exists('genViewIdForTenant')) {
    function genViewIdForTenant($nationality, $id): string
    {
        $prefix = 'JT';
        if ($nationality == \App\Enums\TenantNationalityEnum::AMERICA_KA || $nationality == \App\Enums\TenantNationalityEnum::AMERICA_CI) {
            $prefix = 'UT';
        }
        return $prefix. '-' . str_pad($id, 7, '0', STR_PAD_LEFT);
    }
}

if (!function_exists('convertViewIdToNumber')) {
    function convertViewIdToNumber($viewId)
    {
        return preg_replace('/^[A-Z]{1,2}-0*/', '', $viewId);
    }
}

if (!function_exists('isFullsizeChar')) {
    function isFullsizeChar($char)
    {
        return preg_match('/[^\x00-\x7F]/', $char);
    }
}

if (!function_exists('checkSpaceBetweenNumbers')) {
    function checkSpaceBetweenNumbers($string)
    {
        return preg_match('/\d\s+\d/', $string);
    }
}

if (!function_exists('trimSpace')) {
    function trimSpace($string)
    {
        if (!empty($string)) {
            return trim(preg_replace("@[ 　]@u", ' ', $string));
        }
        return $string;
    }
}

if (!function_exists('hasHyphenBetweenNumbers')){
    function hasHyphenBetweenNumbers($string)
    {
        return preg_match('/\d-\d/', $string);
    }
}

if (!function_exists('parseDateToFormat')){
    function parseDateToFormat($date=null,$format='Y/m/d')
    {
        if ($date){
            return Carbon::parse($date)->format($format);
        }
        return null;
    }
}

if (!function_exists('trimLeadingZeros')) {
    function trimLeadingZeros($value)
    {
        if ($value === '0') {
            return '0';
        }
        if (empty($value)) {
            return null;
        }
        $result = ltrim($value, '0');
        if ($result === '') {
            $result = '0';
        }
        return $result;
    }
}

if (!function_exists('formatDateDefault')) {
    function formatDateDefault($date, $separator='/')
    {
        if (empty($date)) {
            return '';
        }

        $Y = Carbon::parse($date)->format('Y');
        $M = Carbon::parse($date)->format('m');
        $D = Carbon::parse($date)->format('d');

        return $Y . $separator . $M . $separator . $D;
    }
}

if (!function_exists('formatDateByLang')) {
    function formatDateByLang($date = null)
    {
        if (!$date) {
            return null;
        }
        if (getCurrentLangCode() == LanguageEnum::JA) {
            return formatDateJapan($date);
        }
        return formatDateDefault($date);
    }
}

if (!function_exists('formatDayByAmount')) {
    function formatDayByAmount($amount, $inputDate, $dayLT=null, $dayGT=null)
    {
        $inputDate = str_replace('-', '/', $inputDate);
        $paymentPeriodDate = Carbon::createFromFormat('Y/m/d',  $inputDate)->addMonth();
        if ($amount < 0) {
            if (!empty($dayLT)) {
                $paymentPeriodDate = $paymentPeriodDate->setDay($dayLT);
            }
        } else {
            if (!empty($dayGT)) {
                $paymentPeriodDate = $paymentPeriodDate->setDay($dayGT);
            }
        }
        return $paymentPeriodDate;
    }
}

if (!function_exists('formatCurrency')) {
    function formatCurrency($amount): string
    {
        if (fmod($amount, 1) == 0) {
            $formattedNumber = number_format($amount, 0, '.', ',');
        } else {
            $formattedNumber = number_format($amount, 2, '.', ',');
        }

        return $formattedNumber . trans2('JPY');
    }
}

if (!function_exists('convertYYYYMMToNumber')) {
    function convertYYYYMMToNumber($yyyymm): int
    {
        return (int) str_replace('/', '', $yyyymm);
    }
}

if (!function_exists('convertNumberToYYYYMM')) {
    function convertNumberToYYYYMM($yyyymmNumber): string
    {
        return substr($yyyymmNumber, 0, 4) . '/' . substr($yyyymmNumber, 4, 2);
    }
}

if (!function_exists('formatYYYYMM')) {
    function formatYYYYMM($yyyymm): string
    {
        if (!$yyyymm){
            return '';
        }
        if (getCurrentLangCode() == LanguageEnum::JA) {
            list($year, $month) = explode('/', $yyyymm);
            $yyyymm = $year . '年' . (int)$month . '月';
        }

        return $yyyymm;
    }
}

if (!function_exists('buildVersionImg')) {

    function buildVersionImg($file)
    {
        return $file . '?v=' . time();
    }
}


if (!function_exists('formatDateUs')) {
    function formatDateUs($date = null)
    {
        if (!$date) {
            return null;
        }

        $formatDate = substr($date, 0, 2) . '/' . substr($date, 2, 2) . '/' . substr($date, 4, 2);

        return $formatDate;
    }
}

if (!function_exists('uploadFileToS3')) {
    function uploadFileToS3($data)
    {
        $fullFileName = $data['id'] . '-' . $data['path'];
        $path = $data['file']->storeAs($data['folder'], $fullFileName, 's3');
        Storage::disk('s3')->setVisibility($path, 'public');
        return $path;
    }
}

if (!function_exists('formatDoubleNumber')) {
    function formatDoubleNumber($number): string|null
    {
        $number = removeTrailingZeros($number);
        if (!$number) {
            return null;
        }
        return preg_replace('/\B(?=(\d{3})+(?!\d))/', ',', (string)$number);
    }
}

if (!function_exists('removeTrailingZeros')) {
    function removeTrailingZeros($number): null|float|int
    {
        if (!$number) {
            return null;
        }
        $number = floatval($number);
        if (fmod($number, 1) == 0) {
            $number = (int)$number;
        }
        return $number;
    }
}

if (!function_exists('formatNumberWithCommas')) {
    function formatNumberWithCommas($number): string|null
    {
        if (blank($number)) {
            return null;
        }

        $number = floatval($number);
        if (fmod($number, 1) == 0) {
            $number = (int)$number;
        }

        return preg_replace('/\B(?=(\d{3})+(?!\d))/', ',', (string)$number);
    }
}


// logx
if (!function_exists('logx')) {
    function logx(string $x, string $level, string $message, array $context = [])
    {
        try {
            Log::channel(config('logging.default'))->{$level}($message, array_merge($context, ['path' => getArea() . '.' . $x]));
        } catch (Exception $e) {
            \Illuminate\Support\Facades\Log::error($e);
            echo $e->getMessage();
        }
    }
}
if (!function_exists('logxError')) {
    function logxError(string $x, string $message, array $context = [], bool $echo = true)
    {
        logx($x, 'error', $message, $context);
        if ($echo && isBatchArea() && !in_array(config('app.env'), ['live', 'production'])){
            echo $message . PHP_EOL;
        }
    }
}
if (!function_exists('logxInfo')) {
    function logxInfo(string $x, string $message, array $context = [], bool $echo = true)
    {
        logx($x, 'info', $message, $context);
        if ($echo && isBatchArea() && !in_array(config('app.env'), ['live', 'production'])){
            echo $message . PHP_EOL;
        }
    }
}
if (!function_exists('logxDebug')) {
    function logxDebug(string $x, string $message, array $context = [])
    {
        logx($x, 'debug', $message, $context);
    }
}


// array
if (!function_exists('array_group')) {
    function array_group($array, $groupField)
    {
        $arr = array();
        foreach ($array as $item) {
            $arr[$item[$groupField]][] = $item;
        }
        return $arr;
    }
}
if (!function_exists('array_field_to_key')) {
    function array_field_to_key($array, $field, $latest = true)
    {
        $arr = array();
        foreach ($array as $item) {
            if ($latest){
                $arr[$item[$field]] = $item;
            }else if (!isset($arr[$item[$field]])){
                $arr[$item[$field]] = $item;
            }
        }
        return $arr;
    }
}
if (!function_exists('array_items_is_array')) {
    function array_items_is_array($array)
    {
        if (empty($array) || !is_array($array)){
            return false;
        }
        foreach ($array as $item) {
            if (!is_array($item)){
                return false;
            }
        }
        return true;
    }
}
if (!function_exists('array_match_new_value')) {
    function array_match_new_value($array1, $array2)
    {
        foreach ($array1 as $key => $item){
            if (isset($array2[$item])){
                $array1[$key] = $array2[$item];
            }
        }
        return $array1;
    }
}
if (!function_exists('array_insert')) {
    function array_insert(&$array, $inserted, $offset)
    {
        array_splice_assoc($array, $offset, 0, $inserted);
    }
}
if (!function_exists('array_splice_assoc')) {
    function array_splice_assoc(&$input, $offset, $length = 0, $replacement = array())
    {
        $keys = array_keys($input);
        $values = array_values($input);
        array_splice($keys, $offset, $length, array_keys($replacement));
        array_splice($values, $offset, $length, array_values($replacement));
        $input = array_combine($keys, $values);
    }
}

if (!function_exists('array_filter_jp')) {
    function array_filter_jp($arr){
        return array_filter($arr, function($value) { return !is_null($value) && $value !== '' && $value !== '　'; });
    }
}

if (!function_exists('getUserIpAddr')) {
    function getUserIpAddr()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            // IP from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // IP pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}

if (!function_exists('checkFileS3Exist')) {
    function checkFileS3Exist($path)
    {
        try {
            return Storage::disk('s3')->exists($path);
        } catch (Throwable $exception) {
            return false;
        }
    }
}

if (!function_exists('uploadFileLocalToS3')) {
    function uploadFileLocalToS3($pathFileLocal, $pathFileS3)
    {
        return Storage::disk('s3')->put($pathFileS3, file_get_contents($pathFileLocal), 'public');
    }
}

if (!function_exists('getS3FileUrl')) {
    function getS3FileUrl($path)
    {
        if (empty($path)) {
            return '';
        }
        return getConfig('s3.base_url') . '/' . $path;
    }
}

if (!function_exists('encryptWithTime')) {
    function encryptWithTime($input, $configKey)
    {
        if (!$input) {
            return '';
        }

        $rand = randomString();

        $inputString = "{$input}_{$rand}"; //concat input with '_' character and rand

        return myHexEncrypt($inputString, $configKey); //encrypt
    }
}

if (!function_exists('trimDecrypted')) {
    function trimDecrypted($encryptedString,  $configKey)
    {
        if (empty($encryptedString)) {
            return '';
        }

        $stringDecrypted = myHexDecrypt($encryptedString, $configKey); //decrypt

        $listStringExploded = explode('_', $stringDecrypted); //explode string decrypted

        return $listStringExploded[0]; //return value before '_' character
    }
}

if (!function_exists('myHexEncrypt')) {
    function myHexEncrypt($string, $key)
    {
        $result = '';
        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keyChar = substr($key, $i % strlen($key), 1);
            $char = chr(ord($char) + ord($keyChar));
            $result .= $char;
        }

        return bin2hex($result);
    }
}

if (!function_exists('myHexDecrypt')) {
    function myHexDecrypt($string, $key)
    {
        $result = '';
        $string = hex2bin($string);

        for ($i = 0; $i < strlen($string); $i++) {
            $char = substr($string, $i, 1);
            $keyChar = substr($key, $i % strlen($key), 1);
            $char = chr(ord($char) - ord($keyChar));
            $result .= $char;
        }

        return $result;
    }
}

if (!function_exists('checkDateFormat')) {
    function checkDateFormat($value)
    {
        return preg_match("/^(19|20)\d{2}\/(0?[1-9]|1[0-2])\/(0?[1-9]|[12]\d|3[01])$/", $value);
    }
}

if (!function_exists('getCurrentYearMonthFormated')) {
    function getCurrentYearMonthFormated()
    {
        return formatDateJapan(Carbon::now(), 'Ym');
    }
}

if (!function_exists('getCurrentYearFormated')) {
    function getCurrentYearFormated()
    {
        return formatDateJapan(Carbon::now(), 'Y');
    }
}

if (!function_exists('appendZipCodeSymbol')) {
    function appendZipCodeSymbol($zipCode)
    {
        if ($zipCode) {
            $zipCode = trans2('zip_code') . $zipCode;
        }
        return $zipCode;
    }
}

if (!function_exists('appendWithDayCharacter')) {

    function appendWithDayCharacter($value)
    {
        return ($value || $value == '0') ? $value . trans2('txt_day') : null;
    }
}

if (!function_exists('checkWeekday')) {
    function checkWeekday($arrDay, $day)
    {
        if (is_string($arrDay)) {
            $arrDay = explode(',', $arrDay);
        }
        if (empty($arrDay)) {
            return false;
        }
        return in_array($day, $arrDay);
    }
}

if (!function_exists('isPositive')) {
    /**
     * @param mixed $value
     * @return bool
     */
    function isPositive($value): bool
    {
        return !empty($value) && $value > 0;
    }

    if (!function_exists('paginateCollection')) {
    function paginateCollection($collection, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (LengthAwarePaginator::resolveCurrentPage() ?: 1);
        $items = $collection->forPage($page, $perPage)->values();

        return new LengthAwarePaginator($items, $collection->count(), $perPage, $page, $options);
    }
}

}

if (!function_exists('getCurrentTimeFormated')) {
    function getCurrentTimeFormated($format = 'Y.m.d')
    {
        return Carbon::now()->format($format);
    }
}

if (!function_exists('splitContentAndPrefixForQRAndViewId')) {
    function splitContentAndPrefixForQRAndViewId($stringData)
    {
        $prefix = substr($stringData, 0, 3);
        $content = substr($stringData, 3);
        return ['prefix' => $prefix, 'content' => $content];
    }
}

if (!function_exists('formatCurrencyWithYenMark')) {
    function formatCurrencyWithYenMark($amount, $bpTypeIncome = true): string
    {
        if (fmod($amount, 1) == 0) {
            $formattedNumber = number_format($amount, 0, '.', ',');
        } else {
            $formattedNumber = number_format($amount, 2, '.', ',');
        }

        return '¥' . ($bpTypeIncome ? $formattedNumber : '-' . $formattedNumber);
    }
}

if (!function_exists('encryptSodium')) {
    function encryptSodium(string $viewId,string $b64key): string {
        $key = base64_decode($b64key, true); // 32 byte nhị phân
        $nonce = random_bytes(SODIUM_CRYPTO_SECRETBOX_NONCEBYTES);
        $ct    = sodium_crypto_secretbox($viewId, $nonce, $key);
        return base64_encode($nonce . $ct);
    }
}

 if (!function_exists('makeImgQRWithText')) {
    /**
     * Create QR Code from hashId and change to image
     *
     * @param string $hashId        String HashID
     * @return array
     */
     function makeImgQRWithText(string $hashId): array
     {
         $options = new QROptions([
             'outputType' => QRCode::OUTPUT_IMAGE_PNG,
             'outputBase64' => false,
             'scale' => 8,
         ]);

         $qr = new QRCode($options);
         $pngData = $qr->render($hashId);

         $fileName = 'qr_' . time() . '_' . substr(md5($hashId), 0, 8) . '.png';
         $path = getConfig('folder_tenant_qrcode_image'). '/' . $fileName;

         return [
             'binary' => $pngData,
             'path'   => $path
         ];

     }

     if (!function_exists('makeHashIdForTenant')) {
         function makeHashIdForTenant($viewId): string
         {
             $keyBase64 = \App\Models\Setting::first()?->value('tenant_hash_key');
             $encryptViewId = encryptSodium($viewId, $keyBase64);
             return getConstant('PREFIX_TENANT_HASH_ID') . '-' . $encryptViewId;
         }
     }
}

