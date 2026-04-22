<?php

namespace App\Validators\Contracts;

use App\Enums\PropertyRoomGarbageHowtoTypeEnum;
use App\Enums\WeekdayEnum;
use App\Services\TenantService;
use Core\Validators\Concerns\BaseValidatesAttributes;
use Illuminate\Contracts\Translation\Translator;
use Core\Validators\Contracts\BaseValidatorContract;

class CustomValidatorContract extends BaseValidatorContract
{
    use BaseValidatesAttributes;

    /**
     * @param Translator $translator
     * @param array $data
     * @param array $rules
     * @param array $messages
     * @param array $customAttributes
     */
    public function __construct(Translator $translator, array $data, array $rules, array $messages = [], array $customAttributes = [])
    {
        parent::__construct($translator, $data, $rules, $messages, $customAttributes);
    }

    public function validatePhone($attribute, $value, $parameters): bool|int
    {
        $clean = preg_replace('/[\s-]/', '', trim($value));
        if (preg_match('/^\d{9,11}$/', $clean)) {
            return true;
        }

        if (preg_match('/^\d{1,4}-\d{3,4}-\d{3,4}$/', $value)) {
            $digitCount = strlen(preg_replace('/\D/', '', $value));
            if ($digitCount >= 9 && $digitCount <= 11) {
                return true;
            }
        }

        if (preg_match('/^\+\d{2}\d{9,11}$/', $clean)) {
            return true;
        }

        return false;
    }


    public function validateNumber($attribute, $value, $parameters): bool|int
    {
        return preg_match("/^\d+$/", $value);
    }

    public function validateCheckEmail($attribute, $value, $parameters, $validator): bool
    {
        return preg_match("/^([a-z0-9+_\-]+)(\.[a-z0-9+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $value);
    }

    public function validateKatakana($attribute, $value, $parameters): bool|int
    {
        return preg_match('/^([゠ァアィイゥウェエォオカガキギクグケゲコゴサザシジスズセゼソゾタダチヂッツヅテデトドナニヌネノハバパヒビピフブプヘベペホボポマミムメモャヤュユョヨラリルレロヮワヰヱヲンヴヵヶヷヸヹヺ・ーヽヾヿ　 ]+)$/u', $value, $matches);
    }

    public function validateCheckFullSize($attribute, $value, $parameters): bool|int
    {
        return !preg_match('/[^\x00-\x7F]/', $value);
    }

    public function validateCheckZipCode($attribute, $value, $parameters): bool
    {
        return preg_match('/^\d{1,12}$|^\d{3}-\d{4}$/', $value);
    }


    public function validateCheckDateFormat($attribute, $value, $parameters, $validator): bool
    {
        return preg_match("/^(19|20)\d{2}\/(0[1-9]|1[0-2])\/(0[1-9]|[12]\d|3[01])$/", $value);
    }

    public function validateCheckDateYYYYMMFormat($attribute, $value, $parameters, $validator): bool
    {
        return preg_match("/^(19|20)\d{2}\/(0[1-9]|1[0-2])$/", $value);
    }

    public function validateCheckExistYYYYMM($attribute, $value, $parameters, $validator): bool
    {
        if (empty($validator->data['modelBill'])) {
            return false;
        }
        $data = $validator->getData();
        $propertyId = $data['propertyId'];
        $propertyRoomId = $data['propertyRoomId'];
        $currentId = $data['id'] ?? null;
        $yyyymmNumber = convertYYYYMMToNumber($value);

        $query = $data['modelBill']::where([
            ['yyyymm', $yyyymmNumber],
            ['property_id', $propertyId],
            ['property_room_id', $propertyRoomId],
        ]);
        if (empty($currentId)) {
            //case create
            return $query->doesntExist();
        }
        //case update
        return $query->where('id', '!=', $currentId)->doesntExist();

    }

    public function validateCheckIntegerWithLeadingZeros($attribute, $value, $parameters, $validator): bool
    {
        return preg_match("/^\d+$/", $value);
    }

    public function validateCheckInitRequired($attribute, $value, $parameters, $validator): bool
    {
        if ($value == getConfig('init_required')) {
            return false;
        }
        return true;
    }

    public function validateCheckMonthlyRequired($attribute, $value, $parameters, $validator): bool
    {
        if ($value == getConfig('monthly_required')) {
            return false;
        }
        return true;
    }

    public function validateDateUsFormat($attribute, $value, $parameters, $validator): bool
    {
        // check format date MMDDYY
        if (!preg_match('/^(0[1-9]|1[0-2])(0[1-9]|[12][0-9]|3[01])(\d{2})$/', $value, $matches)) {
            return false;
        }

        $month = $matches[1];
        $day = $matches[2];
        $year = '20' . $matches[3];

        if ($month == '02') {
            // Check leap year
            $isLeapYear = ($year % 4 == 0 && ($year % 100 != 0 || $year % 400 == 0));
            if ($isLeapYear && $day > 29) {
                return false;
            } elseif (!$isLeapYear && $day > 28) {
                return false;
            }
        }

        // Check the month has 30 days
        if (in_array($month, getConfig('month_30_days')) && $day > 30) {
            return false;
        }

        // Check the month has 31 days
        if (in_array($month, getConfig('month_31_days')) && $day > 31) {
            return false;
        }

        return true;
    }

    public function validateFileExt($attribute, $value, $parameters, $validator): bool
    {
        $allowedExtensions = $parameters;
        $fileExtension = strtolower($value->getClientOriginalExtension());
        return in_array($fileExtension, $allowedExtensions);
    }

    public function validateCheckWeekDay($attribute, $value, $parameters, $validator): bool
    {
        if (!is_array($value)) {
            return false;
        }

        foreach ($value as $item) {
            if (!in_array($item, WeekdayEnum::getValues())) {
                return false;
            }
        }

        return true;
    }

    public function validateCheckViewId($attribute, $value, $parameters, $validator): bool
    {
        $nationality = data_get($this->data, 'nationality');
        $viewId = data_get($this->data, 'view_id');
        $id = data_get($this->data, 'id');
        return app(TenantService::class)->checkViewId($nationality, $viewId, $id);
    }
}
