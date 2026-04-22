export default {

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    accepted: 'The :attribute must be accepted.',
    accepted_if: 'The :attribute must be accepted when :other is :value.',
    active_url: 'The :attribute is not a valid URL.',
    after: 'The :attribute must be a date after :date.',
    after_or_equal: 'The :attribute must be a date after or equal to :date.',
    alpha: 'The :attribute may only contain letters.',
    alpha_dash: 'The :attribute may only contain letters, numbers, and dashes.',
    alpha_num: 'The :attribute may only contain letters and numbers.',
    array: 'The :attribute must be an array.',
    before: 'The :attribute must be a date before :date.',
    before_or_equal: 'The :attribute must be a date before or equal to :date.',
    between: {
        numeric: 'The :attribute must be between :min and :max.',
        file: 'The :attribute must be between :min and :max mb.',
        string: 'The :attribute must be between :min and :max characters.',
        array: 'The :attribute must have between :min and :max items.',
    },
    boolean: 'The :attribute field must be true or false.',
    confirmed: 'The :attribute confirmation does not match.',
    current_password: 'The password is incorrect.',
    date: 'The :attribute is not a valid date.',
    date_equals: ':attribute should be equal to :date and should be selected as the date.',
    date_format: 'The :attribute does not match the format :format.',
    date_format_ymd: 'The :attribute does not match the format Y/m/d.',
    date_format_ym: 'The :attribute does not match the format Y/m.',
    yyyy_mm_duplicate: 'The monthly fee for that specific period has already been registered.',
    date_format_multiple: 'Please select :attribute in :format format.',
    declined: 'The :attribute must be declined.',
    declined_if: 'The :attribute must be declined when :other is :value.',
    different: 'The :attribute and :other must be different.',
    digits: 'The :attribute must be :digits digits.',
    digits_between: 'The :attribute must be between :min and :max digits.',
    dimensions: 'The :attribute has invalid image dimensions.',
    distinct: 'The :attribute field has a duplicate value.',
    doesnt_end_with: 'The :attribute may not end with one of the following: :values.',
    doesnt_start_with: 'The :attribute may not start with one of the following: :values.',
    email: 'The :attribute must be a valid email address.',
    check_email: 'The :attribute must be a valid email address.',
    slug_format: 'The :attribute must be a valid slug (lowercase letters, numbers, and hyphens only).',
    ends_with: 'The :attribute must end with one of the following: :values.',
    enum: 'The selected :attribute is invalid.',
    exists: 'The selected :attribute is invalid.',
    custom_exists: ':attribute does not exist.',
    file: 'The :attribute must be a file.',
    filled: 'The :attribute field must have a value.',
    gt: {
        numeric: 'Please enter a value for :attribute that is greater than :value.',
        file: 'For :attribute, select a file larger than :value kB.',
        string: 'Please enter :attribute characters longer than :value characters.',
        array: 'Specify at least :value items for :attribute.',
    },
    gte: {
        numeric: ':attributeには、:value以上の値を入力してください。',
        file: ':attributeには、:value kB以上のファイルを選択してください。',
        string: ':attributeは、:value文字以上で入力してください。',
        array: ':attributeには、:value個以上のアイテムを指定してください。',
    },
    image: 'For :attribute, select a file of type jpeg, png, jpg, webp, gif, svg.',
    in: 'The selected :attribute is invalid.',
    in_array: 'The :attribute field does not exist in :other.',
    integer: 'The :attribute must be an integer.',
    ip: 'The :attribute must be a valid IP address.',
    ipv4: 'The :attribute must be a valid IPv4 address.',
    ipv6: 'The :attribute must be a valid IPv6 address.',
    json: 'The :attribute must be a valid JSON string.',
    lt: {
        numeric: 'For :attribute, enter a value smaller than :value.',
        file: 'For :attribute, please select a file smaller than :value kB.',
        string: 'Please enter :attribute with fewer :value characters.',
        array: 'Specify no more than :value items for :attribute.',
    },
    lte: {
        numeric: 'For :attribute, enter a value equal to or less than :value.',
        file: 'For :attribute, select a file less than or equal to :value kB.',
        string: 'Please enter :attribute with :value characters or less.',
        array: 'Specify :value or fewer items for :attribute.',
    },
    mac_address: 'The :attribute must be a valid MAC address.',
    max: {
        array: 'The :attribute may not have more than :max items.',
        file: 'The :attribute may not be greater than :max mb.',
        numeric: 'The :attribute may not be greater than :max.',
        string: 'The :attribute may not be greater than :max characters.',
        file_url: 'The :attribute may not be greater than 5 mb.',
    },
    max_digits: 'The :attribute must not have more than :max digits.',
    mimes: 'The :attribute must be a file of type: :values.',
    file_ext: 'The file must be a file of type: csv.',
    mimetypes: 'The :attribute must be a file of type: :values.',
    min: {
        numeric: 'The :attribute must be at least :min.',
        file: 'The :attribute must be at least :min kilobytes.',
        string: 'The :attribute must be at least :min characters.',
        array: 'The :attribute must have at least :min items.',
    },
    min_digits: 'The :attribute must have at least :min digits.',
    multiple_of: 'The :attribute must be a multiple of :value.',
    not_in: 'The selected :attribute is invalid.',
    not_regex: 'The :attribute format is incorrect.',
    numeric: 'The :attribute must be a number.',
    number: 'Please enter a number for :attribute.',
    password: {
        letters: 'The :attribute must contain at least one letter.',
        mixed: 'The :attribute must contain at least one uppercase and one lowercase letter.',
        numbers: 'The :attribute must contain at least one number.',
        symbols: 'The :attribute must contain at least one symbol.',
        uncompromised: 'The given :attribute has appeared in a data leak. Please choose a different :attribute.',
    },
    present: 'The :attribute field must be present.',
    prohibited: 'The :attribute field is prohibited.',
    prohibited_if: 'The :attribute field is prohibited when :other is :value.',
    prohibited_unless: 'The :attribute field is prohibited unless :other is in :values.',
    prohibits: 'The :attribute field prohibits :other from being present.',
    regex: 'The :attribute format is invalid.',
    required: 'The :attribute field is required.',
    required_select: "Please choose :attribute",
    required_array_keys: 'The :attribute field must contain entries for: :values.',
    required_if: 'The :attribute field is required when :other is :value.',
    required_if_accepted: 'The :attribute field is required when :other is accepted.',
    required_unless: 'The :attribute field is required unless :other is in :values.',
    required_with: 'The :attribute field is required when :values is present.',
    required_with_all: 'The :attribute field is required when :values is present.',
    required_without: 'The :attribute field is required when :values is not present.',
    required_without_all: 'The :attribute field is required when none of :values are present.',
    same: 'The :attribute and :other must match.',
    size: {
        array: 'The :attribute must contain :size items.',
        file: 'The :attribute must be :size kilobytes.',
        numeric: 'The :attribute must be :size.',
        string: 'The :attribute must be :size characters.',
    },
    starts_with: 'The :attribute must start with one of the following: :values.',
    string: 'The :attribute must be a string.',
    timezone: 'The :attribute must be a valid zone.',
    unique: 'The :attribute has already been taken.',
    custom_unique: 'The :attribute has already been taken.',
    uploaded: 'The :attribute failed to upload.',
    url: 'The :attribute format is invalid.',
    uuid: 'The :attribute must be a valid UUID.',
    email_format: 'The email address is invalid.',
    phone: ':attribute is invalid',
    katakana: ':attribute must be entered in full-width katakana.',
    check_full_size: 'Please enter :attribute in half-width numbers.',
    check_zip_code: ':attribute is invalid.',
    required_with_field: ':attribute is required.',
    required_with_select: 'Please select :attribute.',
    check_init_required: 'Initial costs require either income or expenditure to be registered.',
    check_monthly_required: 'Monthly costs require either income or expenditure to be registered.',
    income_expenditure_required: 'Either income or expenditure must be registered.',
    date_us_format: 'The :attribute is not a valid date.',
    selected_id_billing_required: 'Billing is required.',
    selected_id_payment_required: 'Payment is required.',
    move_out_check_init_required: 'You must register the moving out expenses as either income or expenditure.',
    check_week_day: 'The selected :attribute is invalid.',
    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    custom: {
        'attribute-name': {
            'rule-name': 'custom-message',
        },
    },

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    attributes: {
        image_url: 'Image',
        file_url: 'File',
        imageFile: 'Company seal image',
        fax: 'Fax',
        movein_date: 'Move-in date',
        contract_date: 'Contract date',
    },

}
