<?php

return [
    // add
    'create_success' => '登録しました。',
    'create_failed' => '登録に失敗しました。',

    // update
    'update_success' => '編集しました。',
    'update_failed' => '更新に失敗しました。',
    'amount_dont_match' => '金額が一致しません。',

    // delete
    'delete_success' => '削除しました。',
    'delete_failed' => '削除に失敗しました。',

    // change
    'change_success' => '変更しました。',
    'change_failed' => '変更に失敗しました。',

    // search
    'no_result_found' => '検索条件で指定したデータは存在しません。',
    'db_not_connect' => 'DBへの接続に失敗しました。予期せぬエラーが発生していますのでシステム管理者に連絡してください。',
    'url_not_found' => '指定されたページ(URL)は見つかりません。',
    'not_permission' => 'アクセス権限はありません。',
    'no_data' => 'データがありません。',
    'record_does_not_exists' => 'レコードが存在しません。',
    'owner_does_not_exists' => 'オーナー情報がありません。',

    // download
    'download_failed' => 'ダウンロードに失敗しました。',
    'no_file_download' => ':typeのファイルがありません。',

    // mail subject
    'mail_reset_password_title' => 'パスワード再発行',
    'mail_register_complete_title' => 'パートナードライブの会員登録完了',

    // send mail
    'send_success' => '送信しました。',
    'send_failed' => '送信に失敗しました。',
    'reset_password_success' => 'パスワードの再設定が完了しました。',
    'reset_password_fail' => 'パスワード再発行に失敗しました。',
    'send_reset_link_success' => '再発行パスワードのメールを送信しました。:emailをご確認ください。',

    // upload file
    'file_does_not_exist' => 'ファイルが存在しません。',
    'file_upload_failed' => 'ファイルのアップロードに失敗しました。',
    'file_upload_blacklist' => 'アップロードされたファイルはブラックリストに登録されています。',

    // errors
    'system_error' => '予期せぬエラーが発生しました。システム管理者に連絡してください。',
    'failed' => 'お手数ですが再度やり直して下さい。',

    // action
    'page_action' => [
        'index' => '一覧',
        'edit' => '編集',
        'show' => '詳細',
        'confirm' => '確認',
        'create' => '登録',
        'store' => '操作',
        'update' => '操作',
        'destroy' => '削除',
    ],

    // page title
    'page_title' => [
        'errors' => 'エラー',
        'admin' => [
            'login' => 'ログイン',
            'forgot_password' => 'パスワードをお忘れの場合',
            'reset_password' => 'パスワードを再発行',
            'home' => 'ホーム',
            'users' => 'ユーザー',
            'expense_item' => '賃貸管理システム',
        ],
    ],

    'page_title_admin' => '賃貸管理システム',

    // http message code
    'http_code' => [
        200 => '',
        400 => "認証情報が違います。",
        401 => "セッションがタイムアウトしました。\n再度ログインをお願いします。",
        403 => "セッションがタイムアウトしました。\n再度ログインをお願いします。",
        404 => "お探しのページが見つかりませんでした。",
        405 => "メソッドは許可されていません。",
        500 => "システムエラーが発生しました。",
    ],

    // subject mails
    'subject_mails' => [
        'password' => [
            'forgot' => 'パスワード再発行',
            'reset_password' => 'パスワードを再発行',
        ]
    ],

    // messages
    'token_expiration' => 'セッションの有効期限が切れました。 もう一度やり直してください。',
    'curl_api_error' => 'リモート API の呼び出しで curl エラーが発生しました。',
    'push_messages_error' => 'メッセージをデバイスに送信中にエラーが発生しました。',
    'push_messages_success' => 'デバイスへのメッセージの送信に成功しました。',

    // API
    'api_not_connect' => '送信先サーバへの接続に失敗しました。',

    'email_exist' => 'メールアドレスの値は既に存在しています。',
    'slug_exist' => 'スラッグの値は既に存在しています。',

    'full_size_tel' => 'TELは半角数字で入力してください。',
    'zip_with_hyphen_invalid' => '郵便番号（ハイフンあり）が不正です。',
    'full_size_zip_with_hyphen' => '郵便番号（ハイフンあり)は半角数字で入力してください。',
    'zip_invalid' => '郵便番号が不正です。',
    'full_size_zip' => '郵便番号は半角数字で入力してください。',
    'csv_data_invalid' => 'データの形式が正しくありません。',
    'csv_data_number_no_invalid' => ':no行目: データの形式が正しくありません。',

    // GI CSV
    'gi_csv_deposit_date_no_invalid' => ':no行目: 日付データの形式が正しくありません。',
    'gi_csv_view_id_no_invalid' => ':no行目: Cust IDデータの形式が正しくありません。',
    'gi_csv_amount_no_invalid' => ':no行目: 金額データの形式が正しくありません。',

    // holiday check date
    'holidays' => [
        'date_unique' => '既にその休業日は登録されています。',
    ],
];
