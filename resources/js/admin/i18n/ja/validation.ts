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

    accepted: ':attributeを承認してください。',
    accepted_if: ':attribute は :other が :value には承認される必要があります。',
    active_url: ':attribute は有効なURLではありません。',
    after: ':attributeには、:dateより後の日付を選択してください。',
    after_or_equal: ':attributeには、:date以降の日付を選択してください。',
    alpha: ':attribute は英字のみ有効です。',
    alpha_dash: ":attribute は「英字」「数字」「-(ダッシュ)」「_(下線)」のみ有効です。",
    alpha_num: ":attribute は「英字」「数字」のみ有効です。",
    array: ':attribute は配列タイプのみ有効です。',
    before: ':attributeには、:dateより前の日付を選択してください。',
    before_or_equal: ':attributeには、:date以前の日付を選択してください。',
    between: {
        numeric: ':attribute は :min ～ :max までの数値を入力してください。',
        file: ':attribute は :min ～ :max キロバイトまで入力してください。',
        string: ':attribute は :min ～ :max 文字まで入力してください。',
        array: ':attribute は :min ～ :max 個まで入力してください。',
    },
    boolean: ":attributeには、'true'か'false'を指定してください。",
    confirmed: ':attributeと:attribute確認が一致しません。',
    current_password: 'パスワードが不正です。',
    date: ':attribute を有効な日付形式にしてください。',
    date_equals: ':attributeは:dateに等しい日付で選択してください。',
    date_format: ':attribute を :format 書式と一致させてください。',
    date_format_ymd: ':attribute を Y/m/d 書式と一致させてください。',
    date_format_ym: ':attribute を Y/m 書式と一致させてください。',
    yyyy_mm_duplicate: 'すでにその年月料金は登録済みです。',
    date_format_multiple: ':attribute を :format 書式と一致させてください。',
    declined: ':attributeは拒否される必要があります。',
    declined_if: ':attribute は :other が :value には拒否される必要があります。',
    different: ':attribute を :other と違うものにしてください。',
    digits: ':attribute は :digits 桁のみ有効です。',
    digits_between: ':attribute は :min ～ :max 桁のみ有効です。',
    dimensions: ':attribute ルールに合致する画像サイズのみ有効です。',
    distinct: ':attribute に重複している値があります。',
    doesnt_end_with: ':attributeは : :values の中の値で終わらないようにしてください。',
    doesnt_start_with: ':attributeは : :values の中の値で始まらないようにしてください。',
    email: ':attributeが不正です。',
    check_email: ':attributeが不正です。',
    slug_format: ':attributeは有効なスラッグ（小文字、数字、ハイフンのみ）である必要があります。',
    ends_with: ':attributeは : :values の中の値で終わるようにしてください。',
    enum: '選択した:attributeは無効です。',
    exists: ':attributeは存在していません。',
    custom_exists: ':attributeは存在していません。',
    file: ':attribute アップロード出来ないファイルです。',
    filled: ':attribute 値を入力してください。',
    gt: {
        numeric: ':attributeには、:valueより大きな値を入力してください。',
        file: ':attributeには、:value kBより大きなファイルを選択してください。',
        string: ':attributeは、:value文字より長く入力してください。',
        array: ':attributeには、:value個より多くのアイテムを指定してください。',
    },
    gte: {
        numeric: ':attributeには、:value以上の値を入力してください。',
        file: ':attributeには、:value kB以上のファイルを選択してください。',
        string: ':attributeは、:value文字以上で入力してください。',
        array: ':attributeには、:value個以上のアイテムを指定してください。',
    },
    image: ':attributeには、jpeg, png, jpg, webp, gif, svgタイプのファイルを選択してください。',
    in: ':attributeが不正です。',
    in_array: ':attributeが不正です。',
    integer: ':attributeは整数で入力してください。',
    ip: ':attribute IPアドレスの書式のみ有効です。',
    ipv4: ':attribute IPアドレス(IPv4)の書式のみ有効です。',
    ipv6: ':attribute IPアドレス(IPv6)の書式のみ有効です。',
    json: ':attribute 正しいJSON文字列のみ有効です。',
    lt: {
        numeric: ':attributeには、:valueより小さな値を入力してください。',
        file: ':attributeには、:value kBより小さなファイルを選択してください。',
        string: ':attributeは、:value文字より短く入力してください。',
        array: ':attributeには、:value個より少ないアイテムを指定してください。',
    },
    lte: {
        numeric: ':attributeには、:value以下の値を入力してください。',
        file: ':attributeには、:value kB以下のファイルを選択してください。',
        string: ':attributeは、:value文字以下で入力してください。',
        array: ':attributeには、:value個以下のアイテムを指定してください。',
    },
    mac_address: ':attributeは有効なMACアドレスであるようにしてください。',
    max: {
        array: ':attribute は :max 個以下のみ有効です。',
        file: ':attributeのサイズは:max MB未満にしてください。',
        numeric: ':attributeは:maxより小さな数字を入力してください。',
        string: ':attributeは:max文字以内で入力してください。',
        file_url: ':attributeのサイズは5 MB未満にしてください。',
    },
    max_digits: ':attributeは :max 桁以下で入力してください。',
    mimes: ':attributeには、:valuesタイプのファイルを選択してください。',
    file_ext: 'ファイルcsvタイプのファイルを選択してください。',
    mimetypes: ':attributeには、:valuesタイプのファイルを選択してください。',
    min: {
        numeric: ':attributeには、:min以上の数字を入力してください。',
        file: ':attributeには:min MB以上のファイルを選択してください。',
        string: ':attributeは:min文字以上で入力してください。',
        array: ':attributeは:min個以上指定してください。',
    },
    min_digits: ':attributeには、 :min 桁以上で入力してください。',
    multiple_of: ':attributeは :value の倍数でなければなりません。',
    not_in: '選択された:attributeは正しくありません。',
    not_regex: ':attributeが不正です。',
    numeric: ':attributeには数字を入力してください。',
    number: ':attributeには数字を入力してください。',
    password: {
        letters: ':attributeには、文字を含む必要があります。',
        mixed: ':attributeには、大文字と小文字を含む必要があります。',
        numbers: ':attributeには、数字を含む必要があります。',
        symbols: ':attributeには、シンボルを含む必要があります。',
        uncompromised: '指定された :attributeがデータ漏洩に発生しました。別の :attributeを選択してください。',
    },
    present: ':attribute が存在しません。',
    prohibited: ':attributeは禁止されます。',
    prohibited_if: ':otherが :value の場合、:attributeは禁止されます。',
    prohibited_unless: ':attributeは :other が :values にない限り禁止されます。',
    prohibits: ':attributeは :other の存在を禁止します。',
    regex: ':attributeが不正です。',
    required: ":attributeは必須です。",
    required_select: ":attributeを選択してください。",
    required_array_keys: ':attributeには、: :values のエントリーを含む必要があります。',
    required_if: ':attribute は :other が :value には必須です。',
    required_if_accepted: ':otherが承認された場合は、 :attributeが必須です。',
    required_unless: ':attribute は :other が :values でなければ必須です。',
    required_with: ':attribute は :values が入力されている場合は必須です。',
    required_with_all: ':attribute は :values が入力されている場合は必須です。',
    required_without: ':attribute は :values が入力されていない場合は必須です。',
    required_without_all: ':attribute は :values が入力されていない場合は必須です。',
    same: ':attributeと:otherが一致しません。',
    size: {
        array: ':attribute は :size 個のみ有効です。',
        file: ':attribute は :size KBのみ有効です。',
        numeric: ':attribute は :size のみ有効です。',
        string: ':attribute は :size 文字のみ有効です。',
    },
    starts_with: ':attributeは : :values の中の値で始まるようにしてください。',
    string: ':attributeには、文字列を入力してください。',
    timezone: ':attributeは有効なTimezoneを使用してください。',
    unique: ':attributeの値は既に存在しています。',
    custom_unique: ':attributeの値は既に存在しています。',
    uploaded: ':attributeのアップロードに失敗しました。',
    url: ':attributeのURLが不正です。',
    uuid: ':attributeは有効なUUIDを使用してください。',
    email_format: 'メールアドレスが不正です。',
    phone: ':attributeが不正です。',
    katakana: ':attributeは全角カタカナで入力してください。',
    check_full_size: ':attributeは半角数字で入力してください。',
    check_zip_code: ':attributeが不正です。',
    required_with_field: ':attributeは必須です。',
    required_with_select: ':attributeを選択してください。',
    check_init_required: '初期費用は、収入／支出どちらか登録が必要です。',
    check_monthly_required: '月額費用は、収入／支出どちらか登録が必要です。',
    owner_id_required: 'オーナー名が必須です。',
    date_us_format: ':attribute を有効な日付形式にしてください。',
    income_expenditure_required: '収入／支出どちらか登録が必要です。',
    selected_id_billing_required: '請求先は必須です。',
    selected_id_payment_required: '支払先は必須です。',
    move_out_check_init_required: '退去費用は、収入／支出どちらか登録が必要です。',
    check_week_day: '選択した:attributeは無効です。',
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
        image_url: '画像',
        file_url: 'ファイル',
        imageFile: '社印画像',
        fax: 'Fax',
        movein_date: '入居日',
        contract_date: '契約日'
    },

}
