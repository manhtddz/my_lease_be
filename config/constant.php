<?php

return [

    // event
    'EVENT_CONTROLLER_TYPE' => 'controller',
    'EVENT_MODEL_TYPE' => 'eloquent',

    //login two factor
    'SESSION_LOGIN_TWO_FACTOR' => 'session_login_two_factor',

    //screens
    'SCREENS' => [
        'ACCOUNT' => 'account',
        'OWNER' => 'owner',
        'OWNER_MEMO' => 'memo',
        'EXPENSE_ITEM' => 'expenseItem',
        'AREA' => 'area',
        'SUPPLIER' => 'supplier',
        'TENANT' => 'tenant',
        'TENANT_MEMO' => 'memo',
        'PROPERTY' => 'property',
        'PROPERTY_MORE_INFORMATION' => 'propertyMoreInformation',
        'TENANT_PROPERTY' => 'tenantProperty',
        'PROPERTY_ROOM_TAB' => 'propertyRoomTab',
        'MOVE_OUT' => 'moveOut',
        'PARKING' => 'parking',
        'ROOM_INFORMATION' => 'roomInformation',
        'ROOM_OWNER' => 'roomOwner',
        'TENANT_PAYMENT_INVOICE' => 'tenantPaymentInvoice',
        'TENANT_PAYMENT_INVOICE_DATE' => 'tenantPaymentInvoiceDate',
        'OWNER_PAYMENT_INVOICE_DATE' => 'ownerPaymentInvoiceDate',
        'PROPERTY_PAYMENT_INVOICE_DATE' => 'propertyPaymentInvoiceDate',
        'UTILITIES' => 'utilities',
        'PROPERTY_ROOM_UTILITY_COST' => 'propertyRoomUtilityCost',
        'ROOM_BILL' => 'roomBill',
        'YELLOW' => 'yellow',
        'OWNER_OTHER_NOTE' => 'ownerOtherNote',
        'MAINTENANCE_COST' => 'maintenanceCost',
        'PAYMENT_INVOICE_DETAIL' => 'paymentInvoiceDetail',
        'PROPERTY_OTHER_NOTE' => 'propertyOtherNote',
        'UPLOAD_PROPERTY_FILE' => 'uploadPropertyFile',
        'PROPERTY_IMAGE' => 'propertyImage',
        'OWNER_PAYMENT_INVOICE' => 'ownerPaymentInvoice',
        'PROPERTY_PAYMENT_INVOICE' => 'propertyPaymentInvoice',
        'MONTHLY_SETTING' => 'monthlySetting',
        'UPLOAD_ROOM_FILE' => 'uploadRoomFile',
        'UPLOAD_ROOM_IMAGE' => 'uploadRoomImage',
        'CREATE_ROOM' => 'createRoom',
        'OWNER_ROOM' => 'ownerRoom',
        'UPLOAD_CSV_FILE' => 'uploadCsvFile',
        'SETTING' => 'setting',
        'MILITARY' => 'military',
        'MAINTENANCE' => 'maintenance',
        'MAINTENANCE_HISTORY' => 'menteHis',
        'PROPERTY_ROOM_OWNER_OTHER_NOTE' => 'roomOwnerOtherNote',
        'ROOM_OWNER_PAYMENT_INVOICE' => 'roomOwnerPaymentInvoice',
        'ROOM_OWNER_PAYMENT_INVOICE_DATE' => 'roomOwnerPaymentInvoiceDate',
        'HOLIDAY' => 'holiday',
        'BLOG_ARTICLE' => 'blogArticle',
    ],

    'PER_PAGE_DEFAULT' => 1,
    'COOKIE_EXPIRE' => 30 * 24 * 60,// 30 days
    'INVOICE_DATE_END' => 99,
    'PER_PAGE_DASHBOARD' => 10,

    // pdf
    'TMP_MEDIA_PDF_NAME' => env('TMP_MEDIA_LINK_NAME', '/app/public') . '/pdf',
    'TMP_MEDIA_PDF' => storage_path() . env('TMP_MEDIA_ROOT_NAME', '/app/public') . '/pdf/',
    'TMP_MEDIA_HTML' => storage_path() . env('TMP_MEDIA_ROOT_NAME', '/app/public') . '/html/',
    'ID_EXPENSE_ITEM_SPECIALS' => [10001, 10002, 10003, 10004, 10005, 10006, 10007, 10008],

    'OWNER' => 'owner',
    'TENANT' => 'tenant',
    'ALL' => 'all',
    'DEFAULT_VALUE' => 'default',

    // map
    'GOOGLE_MAPS_DEFAULT_TRAVEL_MODE' => env('GOOGLE_MAPS_DEFAULT_MODE','driving'),
    'GOOGLE_MAPS_DEFAULT_UNITS' => env('GOOGLE_MAPS_DEFAULT_UNITS','imperial'),
    'GOOGLE_MAPS_DEFAULT_LANGUAGE' => env('GOOGLE_MAPS_DEFAULT_LANGUAGE','en'),
    'GOOGLE_MAPS_API_KEY_FRONTEND' => env('GOOGLE_MAPS_API_KEY_FRONTEND',''),

    'MAX_BED_ROOM' => 5,
    'MAX_BATH_ROOM' => 3,
    'MAX_PARKING' => 4,

    'EXPENSE_ITEM_ID_RENT' => env('EXPENSE_ITEM_ID_RENT',124),
];
