<?php

return [
    'crypt_secret_key' => 'paraline',
    // routes config
    'routes' => [
        'api' => [
            'prefix' => env('API_PREFIX', 'api'),
            'middleware' => 'api',
            'namespace' => '\Api',
            'as' => 'api.',
        ],
        'admin' => [
            'prefix' => env('ADMIN_PREFIX', 'management'),
            'middleware' => 'admin',
            'namespace' => '\Admin',
            'as' => 'admin.',
        ],
        'web' => [
            'prefix' => env('WEB_PREFIX', '/'),
            'middleware' => 'web',
            'namespace' => '\Web',
            'as' => 'web.',
        ],
    ],

    // model field
    'model_field' => [
        'created' => ['at' => 'created_at', 'by' => ''],
        'updated' => ['at' => 'modified_at', 'by' => ''],
        'deleted' => ['flag' => 'del_flag', 'at' => '', 'by' => ''],
    ],

    // model field name
    'model_field_name' => [
        'deleted_flag' => '削除フラグ',
        'created_at' => '登録日時',
        'created_by' => '登録者ID',
        'updated_at' => '更新日時',
        'updated_by' => '更新者ID',
        'deleted_at' => '削除日時',
        'deleted_by' => '削除者ID',
    ],

    // deleted flag
    'deleted_flag' => [
        'off' => 0,
        'on' => 1,
    ],

    // static version for js, css...
    'static_version' => env('STATIC_VERSION', date('YmdHis')),

    // upload
    'media_dir' => 'uploaded/media',
    'ext_blacklist' => ['php', 'phtml', 'html'],
    'tmp_upload_dir' => 'tmp_uploads',
    'no_avatar' => 'assets/css/admin/img/image_default.png',

    // file info
    'file' => [
        'default' => [
            'image' => [
                'ext' => ['jpeg', 'jpg', 'png', 'gif', 'JPG', 'JPEG', 'PNG', 'GIF'], // extension
                'size' => ['min' => 0.001, 'max' => 20], // MB
                'accept' => '.jpeg, .jpg, .png, .gif, .JPG, .JPEG, .PNG, .GIF'
            ]
        ],
    ],

    // export CSV
    'csv' => [
        'users' => [
            'filename' => 'users_' . date('YmdHis'),
            'header' => [
                'id' => 'ID',
                'name' => '名前',
                'email' => 'メールアドレス',
                'created_at' => '登録日時',
                'updated_at' => '更新日時',
            ],
        ],
    ],

    // paginate number
    'page_number' => 10,

    // gmo
    'gmo' => [
        'url' => env('GMO_URL', ''),
        'url_link_type' => env('GMO_URL_LINK_TYPE', ''),
        'public_key' => env('GMO_PUBLIC_KEY', ''),
        'hash_key' => env('GMO_HASH_KEY', ''),
        'site_id' => env('GMO_SITE_ID', ''),
        'site_pass' => env('GMO_SITE_PASS', ''),
        'shop_id' => env('GMO_SHOP_ID', ''),
        'shop_pass' => env('GMO_SHOP_PASS', ''),
    ],

    // logs
    'logs' => [
        'sql_log_filename' => 'sql',
        'zip_log' => [
            'keep_day' => env('ZIP_LOG_KEEP_DAY', 5),
        ],
        'dump_db' => [
            'file_name' => 'database_backup_' . date('YmdHis') . '.sql.gz',
            'path' => storage_path('/backups/database'),
            'max_file' => env('DUMP_DB_MAX_FILE', 7),
        ],
    ],

    // fire base
    'fire_base' => [
        'url_get_info' => 'https://iid.googleapis.com/iid/info/',
        'url_add_topic' => 'https://iid.googleapis.com/iid/v1:batchAdd',
        'url_remove_topic' => 'https://iid.googleapis.com/iid/v1:batchRemove',
        'url_send' => 'https://fcm.googleapis.com/fcm/send',
        'server_key' => env('FCM_SERVER_KEY', ''), // use Server key
        'sound' => '', // sound
        'limit_tokens' => 100,
    ],

    // password reset expired time
    'password_reset_expired_time' => 15, // minutes

    'http_client_verify' => env('HTTP_CLIENT_VERIFY', true),

    // postgres application prefix name
    'postgres_application_prefix' => env('POSTGRES_APPLICATION_PREFIX', 'application'),
    'mail_login_confirm_subject' => '【LeaseMart】認証コード',
    'mail' => [
        'api_url' => env('API_MAIL_URL'),
        'api_token' => env('API_MAIL_TOKEN'),
        'mail_from' => env('MAIL_FROM_ADDRESS')
    ],

    'account' => [
        'status' => [
            1 => '有効',
            0 => '無効',
        ]
    ],

    'payment_date_type' => [
        'not_paid' => 1,
        'paid' => 2,
        'all' => 3
    ],

    'deposit_status' => [
        'not_paid' => 1,
        'paid' => 2,
    ],

    'billing_address_type' => [
        'all' => 1,
        'tenant' => 2,
        'owner' => 3,
        'business_partner' => 4,
    ],

    'disable_two_factor' => env('DISABLE_TWO_FACTOR', false),

    'cookie_per_page_name' => 'cookie_per_page',
    'init_required' => 'init_required',
    'monthly_required' => 'monthly_required',
    'tab_tenant_init' => 'tenant-init',
    'tab_tenant_month' => 'tenant-month',
    'tab_owner_init' => 'owner-init',
    'tab_owner_month' => 'owner-month',
    'tenant_payment_invoice_billing' => 'Billing',
    'tenant_payment_invoice_payment' => 'Payment',
    'owner_payment_invoice_billing' => 'owner-billing',
    'owner_payment_invoice_payment' => 'owner-payment',
    'owner_rent_setting' => 'owner-rent-setting',
    'property_payment_invoice_billing' => 'property-billing',
    'property_payment_invoice_payment' => 'property-payment',
    'room_owner_payment_invoice_payment' => 'room-owner-payment',
    'room_owner_payment_invoice_billing' => 'room-owner-billing',
    'room_owner_rent_setting' => 'room-owner-rent-setting',

    'invoice_date_flag' => [
        1 => '1日',
        2 => '2日',
        3 => '3日',
        4 => '4日',
        5 => '5日',
        6 => '6日',
        7 => '7日',
        8 => '8日',
        9 => '9日',
        10 => '10日',
        11 => '11日',
        12 => '12日',
        13 => '13日',
        14 => '14日',
        15 => '15日',
        16 => '16日',
        17 => '17日',
        18 => '18日',
        19 => '19日',
        20 => '20日',
        21 => '21日',
        22 => '22日',
        23 => '23日',
        24 => '24日',
        25 => '25日',
        26 => '26日',
        27 => '27日',
        99 => '末日',
    ],

    'invoice_limit_flag' => [
        1 => '発生日翌月1日',
        2 => '発生日翌月2日',
        3 => '発生日翌月3日',
        4 => '発生日翌月4日',
        5 => '発生日翌月5日',
        6 => '発生日翌月6日',
        7 => '発生日翌月7日',
        8 => '発生日翌月8日',
        9 => '発生日翌月9日',
        10 => '発生日翌月10日',
        11 => '発生日翌月11日',
        12 => '発生日翌月12日',
        13 => '発生日翌月13日',
        14 => '発生日翌月14日',
        15 => '発生日翌月15日',
        16 => '発生日翌月16日',
        17 => '発生日翌月17日',
        18 => '発生日翌月18日',
        19 => '発生日翌月19日',
        20 => '発生日翌月20日',
        21 => '発生日翌月21日',
        22 => '発生日翌月22日',
        23 => '発生日翌月23日',
        24 => '発生日翌月24日',
        25 => '発生日翌月25日',
        26 => '発生日翌月26日',
        27 => '発生日翌月27日',
        99 => '発生日翌月末日',
    ],

    'supplier_limit' => 5,
    'rent_setting_tab_default' => 'mon',
    'room_owner_rent_setting_tab_default' => 'room_owner_rent_mon',
    'field_checkbox' => [
        'yellow_card' => [
            'bath_full',
            'bath_12',
            'bath_jacuzzi',
            'bath_washlet',
            'kitchen_stove',
            'kitchen_connection_for_stove',
            'kitchen_refrig',
            'kitchen_connection_for_refrig',
            'kitchen_oven',
            'kitchen_microwave',
            'kitchen_dishwasher',
            'kitchen_disposal',
            'washer',
            'connection_for_washer',
            'connection_for_dryer',
            'gas_dryer',
            'electric_dryer',
            'garage',
            'parking_space',
            'other',
            'water_heater_kerosene',
            'water_heater_gas',
            'water_heater_electric',
            'water_heater_all_electric',
            'air_cond_heater_central',
            'air_cond_heater_window',
            'air_cond_heater_wall_mounted',
            'utilities_paid_by_landlord',
            'utilities_paid_by_tenant',
            'community_information_fitness',
            'community_information_clubhouse',
            'community_information_waterfront',
            'community_information_playground',
            'community_information_waterview',
            'community_information_community_courts',
            'features_utility_shed',
            'features_outside_storage',
            'features_office_extraroom',
            'features_patio',
            'features_fenced_yard',
            'features_balcony',
            'features_garage_door_opener',
            'features_pool',
            'features_internet_ready',
            'features_window_coverings',
            'features_skylights',
            'safety_alarm_system',
            'safety_gate_access',
            'safety_door_bell',
            'safety_smoke_detector',
        ]
    ],
    'pdf_extension_path' => app_path() . env('LIB_CONVERT_HTML_PDF_SRC', ''), // wkhtmltox | wkhtmltox_linux
    'month_30_days' => ['04', '06', '09', '11'],
    'month_31_days' => ['01', '03', '05', '07', '08', '10', '12'],
    'maintenance_cost' => [
        'owner' => 'オーナー',
        'tenant' => '入居者',
        'supplier' => '取引先'
    ],
    'folder_maintenance_history_name' => 'maintenance_history',
    'folder_property_file' => 'property_file',
    'folder_property_image' => 'property_image',
    'folder_stamp_image' => 'stamp',
    'folder_setting_image' => 'setting_image',
    'nationality_japan_base_id' => 99,
    'youtube' => [
        'base_url' => 'https://youtube.com/',
        'url_embed_no_cookie' => 'https://www.youtube-nocookie.com/embed/',
    ],
    'folder_room_file' => 'room_file',
    'folder_room_image' => 'room_image',
    'page_number_images' => 12,
    'page_params' => [
        'room_image' => 'page_ri_',
        'room_file' => 'page_rf_',
        'property_image' => 'page_pi',
        'property_file' => 'page_pf',
    ],
    's3' => [
        'base_url' => env('AWS_URL', 'https://untd-leasmart-dev-contents.s3.ap-northeast-1.amazonaws.com')
    ],
    'payment_invoice_subject_mail' => '【Leasmart】請求書送付のご案内',
    'payment_invoice_subject_mail_en' => '【Leasmart】Information on sending invoices',
    'folder_tenant_payment_invoice' => 'tenant_payment_invoice',
    'folder_property_payment_invoice' => 'property_payment_invoice',
    'folder_owner_payment_invoice' => 'owner_payment_invoice',

    'expense_item_id' => [
        'electric' => 10001,
        'gas' => 10003,
        'water' => 10005,
        'garbage' => 10007,
    ],
    'tax_rate_income_csv' => [
        1 => '課税売上 10%',
        2 => '課税売上 8%（軽減税率）',
        3 => '課税売上 8%',
        4 => '対象外',
    ],
    'tax_rate_expenditure_csv' => [
        1 => '課税仕入 10%',
        2 => '課税仕入 8%（軽減税率）',
        3 => '課税仕入 8%',
        4 => '対象外',
    ],
    'payment_invoice_detail_headers' => [
        '取引No',
        '取引日',
        '費用項目',
        '税区分',
        '金額',
        '摘要',
    ],

    'payment_invoice_paid_headers' => [
        '取引No',
        '取引日',
        '借方勘定科目',
        '借方補助科目',
        '借方部門',
        '借方取引先',
        '借方税区分',
        '借方インボイス',
        '借方金額(円)',
        '借方税額',
        '貸方勘定科目',
        '貸方補助科目',
        '貸方部門',
        '貸方取引先',
        '貸方税区分',
        '貸方インボイス',
        '貸方金額(円)',
        '貸方税額',
        '摘要',
        '仕訳メモ',
        'タグ',
        'MF仕訳タイプ',
        '決算整理仕訳',
        '作成日時',
        '作成者',
        '最終更新日時',
        '最終更新者',
    ],

    'RoomTypeText' => [
        1 => 'ルーム',
        2 => 'K',
        3 => 'DK',
        4 => 'SDK',
        5 => 'LDK',
        6 => 'SLDK',
    ],

    'csv_sample_headers' => [
        '日付',
        '出金',
        '入金',
        '適要',
    ],

    'csv_sample_file_name' => '消込CSVフォーマット',

    'csv_gi_sample_headers' => [
        'Cust ID',
        'お名前',
        '物件名',
        '金額',
    ],

    'csv_gi_sample_file_name' => 'GI消込CSVフォーマット',
    'mail_admin_frontend'=> env('MAIL_ADMIN_FRONTEND','hello@example.com'),
    'link_map' => 'https://www.google.com/maps?q=',
];
