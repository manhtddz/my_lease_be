<?php

return [
    'DISABLED' => 'Disabled',
    'ENABLED' => 'Enabled',

    'all' => 'All',
    'required' => 'Required',
    'select_default' => 'Please select',
    'placeholder_date' => 'yyyy/mm/dd',
    'placeholder_date_ym' => 'yyyy/mm',
    'choice' => 'Choice',
    'selection' => 'selection',
    'JPY' => 'JPY',
    'zip_code' => 'ZIP Code',
    'year' => '/',
    'month' => '/',
    'day' => '/',
    'hash_symbol' => '#',
    'txt_day' => 'day',
    'post' => 'post',
    'can' => 'can',

    'per_page' => [
        20 => '20 Results',
        40 => '40 Results',
        50 => '50 Results',
    ],
    'date' => 'Y/m/d',

    'payment_date_type' => [
        3 => 'All',
        1 => 'Unpaid',
        2 => 'Paid',
    ],

    'payment_date_type2' => [
        3 => 'All',
        1 => 'Unpaid',
        2 => 'Paid',
    ],

    'deposit_status' => [
        1 => 'UnPaid',
        2 => 'Payment',
    ],

    'deposit_status2' => [
        1 => 'Unpaid',
        2 => 'Paid',
    ],

    'billing_address_type' => [
        1 => 'All',
        2 => 'Tenant',
        3 => 'Owner',
        4 => 'Client',
    ],

    // button text
    'button' => [
        'regis_move_in' => 'I will move in',
        'regis_all' => 'Register selected details all at once',
        'search' => 'Search',
        'clear' => 'Clear',
        'register' => 'Register',
        'confirm_close_modal' => 'Close without saving',
        'cancel_close_modal' => 'Return',
        'edit' => ' Edit',
        'delete' => 'Delete',
        'close' => 'Close',
        'edit_to' => 'Edit to',
        'change' => 'Change',
        'delete_to' => 'Delete',
        'confirm' => 'Confirmation',
        'unlock' => 'unlock',
        'detail' => 'Detail',
        'back_to_index' => 'Back to index',
        'login' => 'Login',
        'logout' => 'Logout',
        'authenticate' => 'Authenticate',
        'send' => 'Send',
        'profile' => 'Profile',
        'joint_guarantor' => 'Add Joint Guarantor',
        'add_housemate' => 'Add Housemate',
        'add_emergency' => 'Add Emergency Contact',
        'moving_out' => 'Moving Out',
        'moving_in' => 'Return To Occupancy',
        'create_room' => 'Room Registration',
        'add_item' => 'Add item',
        'to_evict' => 'Wait to move out',
        'quit' => 'Quit',
        'add' => 'Add',
        'remove' => 'Remove',
        'download' => 'Download',
        'img_select' => 'Image selection',
        'upload' => 'Upload',
        'to_upload' => 'To upload',
        'registration' => ' Registration',
        'save' => 'Save',
        'status_change' => 'Status Change',
        'help' => 'Help',
        'property_room_hp_publish' => 'Listed On HP',
        'property_room_hp_no_publish' => 'HP No Listed',
    ],

    'confirm_modal' => [
        'regis_move_in' => 'I will move in. Is that okay?',
        'register' => "I'd like to register. Is this OK?",
        'edit' => 'Edit it. Are you sure?',
        'delete' => 'Delete it. Are you sure?',
        'unlock' => 'Unlocking it. Are you sure?',
        'paid_billing' => 'Mark as received payment. Are you sure?',
        'paid_payment' => 'Mark as paid. Are you sure?',
        'unpaid_billing' => 'Mark as unpaid. Are you sure?',
        'unpaid_payment' => 'Mark as unpaid. Are you sure?',
        'reflected_payment' => 'Reflected. Are you sure?',
        'exit-modal' => 'Not saved. Are you sure?'
    ],

    // enum
    'SidebarMenuEnum' => [
        'DASHBOARD' => 'Dashboard',
        'PROPERTY' => 'Property',
        'OWNER' => 'Owner',
        'TENANT' => 'Tenant',
        'INVOICE' => 'Invoice',
        'PAYMENT' => 'Payment',
        'LEASEMART_AI' => 'Leasmart AI',
        'VARIOUS_SETTINGS' => 'Various settings',
        'ACCOUNT' => 'Account',
        'SUPPLIER' => 'Supplier',
        'EXPENSE_ITEM' => 'Expense item',
        'AREA' => 'Area',
        'LOGOUT' => 'Logout',
        'SETTING' => 'Setting',
        'HOLIDAY' => 'Holiday',
        'BLOG_ARTICLE' => 'Blog Article',
    ],

    'room_tab_title' => [
        'tenant_info' => 'Tenant Information',
        'room_info' => 'Room Information',
        'owner' => 'Owner',
        'billing_list' => 'Billing List',
        'payment_list' => 'Payment List',
        'utility' => 'Utilities',
        'rent_setting' => 'Rent Setting',
        'parking' => 'Parking',
        'yellow_card' => 'YellowCard',
        'military' => 'Military Inspection Application',
        'room_file' => 'File',
        'room_image' => 'Images and Videos',
        'maintenance' => 'Maintenance',
        'resident-demand-seat' => 'Resident History',
        'residence_period' => 'Residence Period',
    ],

    'AuthRoleEnum' => [
        'ADMIN' => 'ADMIN',
        'TRIAL' => 'TRIAL',
        'MEMBER' => 'MEMBER',
    ],
    'GMOPaymentMethodEnum' => [
        'CREDIT_CARD' => 'クレジットカード',
        'BANK_TRANSFER' => '銀行振込',
        'CONVENIENCE_STORE' => 'コンビニ決済',
        'AMAZON_PAY' => 'Amazon Pay',
        'PAYPAY' => 'PAYPAY',
        'CREDIT_CONTINUATION' => 'クレジットカード継続課金を追加',
    ],
    'BankAccountTypeEnum' => [
        'NORMAL' => 'Normal',
        'CURRENT' => 'Current',
    ],
    'ArticleStatusEnum' => [
        'DRAFT' => 'Draft',
        'PUBLISHED' => 'Published',
        'ARCHIVED' => 'Archived',
    ],
    'ParkingCertificateTypeEnum' => [
        'ARRANGE_MANAGEMENT_COMPANY' => 'Arrange management company',
        'INTERNAL_ARRANGEMENT' => 'Internal arrangement',
    ],
    'ParkingTypeEnum' => [
        'ARRANGE_MANAGEMENT_COMPANY' => 'Arrange management company',
        'INTERNAL_ARRANGEMENT' => 'Internal arrangement',
    ],
    'PropertyTypeEnum' => [
        'APARTMENT' => 'APARTMENT',
        'CONDOMINIUM' => 'CONDOMINIUM',
        'DETACHED_HOUSE' => 'DETACHED HOUSE',
        'OTHER' => 'OTHER',
    ],
    'RelationshipTypeEnum' => [
        'SPOUSE' => 'SPOUSE',
        'RELATIVES' => 'RELATIVES',
        'FRIEND' => 'FRIEND',
        'COLLEAGUE' => 'COLLEAGUE',
        'PARENT' => 'PARENT',
        'CHILD' => 'CHILD',
        'OTHER' => 'OTHER',
    ],
    'TenantEmergencyContactEnum' => [
        'SPOUSE' => 'SPOUSE',
        'RELATIVES' => 'RELATIVES',
        'FRIEND' => 'FRIEND',
        'COLLEAGUE' => 'COLLEAGUE',
        'PARENT' => 'PARENT',
        'CHILD' => 'CHILD',
        'OTHER' => 'OTHER',
    ],
    'TenantPetAvailableEnum' => [
        'NO' => 'No',
        'YES' => 'Yes',
    ],
    'RentPaymentTypeEnum' => [
        'GI_BILL' => 'GI Bill',
        'UNITED' => 'United',
        'TENANT_SELF' => 'Tenant self',
        'CREDIT' => 'Credit',
        'BANK_TRANSFER' => 'Bank Transfer',
        'INCLUDED' => 'Included',
        'OTHER' => 'Other',
    ],
    'TenantUtilityTypeEnum' => [
        'GI_BILL' => 'GI Bill',
        'UNITED' => 'United',
        'TENANT_SELF' => 'Tenant self',
        'CREDIT' => 'Credit',
        'BANK_TRANSFER' => 'Bank Transfer',
        'INCLUDED' => 'Included',
        'OTHER' => 'Other',
    ],
    'TenantPropertyStatusEnum' => [
        'UNDER_CONTRACT' => 'UNDER_CONTRACT',
        'CONTRACT_EXPIRED' => 'CONTRACT_EXPIRED',
        'MANAGEMENT_ENDED' => 'MANAGEMENT_ENDED',
    ],
    'AccountLockFlagEnum' => [
        'RELEASE' => 'RELEASE',
        'LOCK' => 'LOCK'
    ],
    'TenantBranchEnum' => [
        'AIRFORCE' => 'AIRFORCE',
        'NAVY' => 'NAVY',
        'MARINE' => 'MARINE',
        'ARMY' => 'ARMY',
        'OTHER' => 'OTHER',
    ],
    'ServiceTenantEnum' => [
        'ACTIVE_DUTY' => 'ACTIVE_DUTY',
        'CIVILIAN' => 'CIVILIAN',
        'GS' => 'GS',
        'RETIRED' => 'RETIRED',
        'OTHER' => 'OTHER',
    ],
    'JointGuarantorRelationshipEnum' => [
        'SPOUSE' => 'SPOUSE',
        'RELATIVES' => 'RELATIVES',
        'FRIEND' => 'FRIEND',
        'COLLEAGUE' => 'COLLEAGUE',
        'PARENT' => 'PARENT',
        'CHILD' => 'CHILD',
        'OTHER' => 'OTHER',
    ],
    'ExpenseItemTypeEnum' => [
        'INCOME' => 'Income',
        'EXPENDITURE' => 'Expenditure',
    ],
    'SupplierTypeEnum' => [
        'MANAGEMENT_COMPANY' => ' Management Company',
        'ELECTRICITY' => 'Electricity',
        'GAS' => 'Gas',
        'WATER_SUPPLY' => 'Water Supply',
        'GARBAGE' => 'Garbage',
        'OTHER' => 'Other',
    ],
    'PropertySupplierTypeEnum' => [
        'MANAGEMENT_COMPANY' => 'Management Company',
        'ELECTRICITY' => 'Electricity',
        'GAS' => 'Gas',
        'WATER_SUPPLY' => 'Water Supply',
        'GARBAGE' => 'Garbage',
        'OTHER' => 'Other',
    ],
    'OwnerContractStatusEnum' => [
        'UNDER_CONTRACT' => 'Under Contract',
        'CONTRACT_EXPIRED' => 'Contract expired'
    ],
    'SepticTankEnum' => [
        'NO' => 'No',
        'YES' => 'Yes',
    ],
    'SupplierFlagEnum' => [
        'OUR_COMPANY' => 'Company',
        'OTHER_COMPANY' => 'Other company',
    ],

    'HpPublicFlagEnum' => [
        'NOT_LISTED' => 'Not listed',
        'PUBLISH' => 'Publish',
    ],

    'WaterCheckFlagEnum' => [
        'MUNICIPALITY' => 'municipality',
        'MANAGEMENT_COMPANY_METER_READING' => 'Management company meter reading',
        'COMPANY_METER_READING' => 'Company meter reading',
    ],
    'RentGuaranteeTypeEnum' => [
        'ADD_IF_NECESSARY' => 'Add if necessary',
        'USE_IF_POSSIBLE' => 'Use if possible',
    ],
    'PropertyDrawingsFlagEnum' => [
        'NONE' => 'None',
        'AVAILABLE' => 'Available',
    ],
    'ParkingDrawingsFlagEnum' => [
        'NONE' => 'None',
        'AVAILABLE' => 'Available',
    ],
    'NetConnectionStatusEnum' => [
        'TENANT_ARRANGEMENT' => 'Tenant Arrangement',
        'SHARED_INTERNET_AVAILABLE' => 'Shared Internet Available',
    ],
    'PetStatusEnum' => [
        'NOT_ALLOWED' => 'No Pet',
        'NEGOTIABLE' => 'Negotiable',
        'LARGE_DOG' => 'Dog OK (Large Dog OK)',
        'ONLY_SMALL_DOG' => 'Small Dog Only OK',
        'CAT_ALLOWED' => 'Cat OK'
    ],
    'StructureTypeEnum' => [
        'CB' => 'CB (Concrete Block)',
        'RC' => 'RV (Reinforced Concrete)',
        'RCB' => 'RCB (Reinforced Concrete Block)',
        'SRC' => 'SRC (Steel Reinforced Concrete)',
        'PC' => 'PC (Prestressed Concrete)',
        'HPC' => 'HPC (High-Performance Precast Concrete)',
        'ALC' => 'ALC (Autoclaved Lightweight Concrete)',
        'WOOD' => 'Wooden',
        'S' => 'S (Steel Frame)',
        'OTHER' => 'Other',
    ],
    'InoutNotificationFlagEnum' => [
        'NONE' => 'None',
        'AVAILABLE' => 'Available',
    ],
    'PropertyTabEnum' => [
        'PROPERTY_INFORMATION' => 'Property Information',
        'MORE_INFORMATION' => 'More Information',
        'ROOM' => 'Room',
        'OWNER' => 'Owner',
        'PAYMENT_LIST' => 'Payment List',
        'BILLING_LIST' => 'Billing List',
        'MONTHLY_FEE_SETTING' => 'Monthly Fee Setting',
        'FILE' => 'File',
        'IMAGES_AND_VIDEOS' => 'Images and Videos',
        'OTHER_NOTES' => 'Other Notes',
    ],
    'PropertyRoomMoveInStatusEnum' => [
        'MOVE_IN' => 'Move In',
        'VACANT' => 'Vacant',
        'AWAITING_MOVE_OUT' => 'Awaiting Move Out',
        'MOVED_OUT' => 'Moved Out',
        'UNDER_MILITARY_INSPECTION' => 'Under Military Inspection',
        'MILITARY_INSPECTION_COMPLETE' => 'Military Inspection Complete',
        'CLEANING_IN_PROGRESS' => 'Cleaning In Progress',
        'MOVE_IN_PROCEDURE_IN_PROGRESS' => 'Move In Procedure In Progress',
        'MANAGEMENT_ENDED' => 'Management Ended',
    ],
    'PropertyRoomTypeEnum' => [
        'HOUSE' => 'House',
        'APARTMENT' => 'Apartment',
        'DUPLEX' => 'Duplex',
    ],
    'PropertyRoomRoomTypeEnum' => [
        'ROOM' => 'Room',
        'K' => 'K',
        'DK' => 'DK',
        'SDK' => 'SDK',
        'LDK' => 'LDK',
        'SLDK' => 'SLDK',
    ],
    'PropertyRoomGarbageHowtoTypeEnum' => [
        'DESIGNATED_GARBAGE_BAG' => 'Designed Bag',
        'CLEAR_BAG' => 'Clear Bag',
        'TIE_WITH_STRING' => 'Bundle',
        'OTHER' => 'Other',
    ],
    'WeekdayEnum' => [
        'MONDAY' => 'Mon',
        'TUESDAY' => 'Tue',
        'WEDNESDAY' => 'Wed',
        'THURSDAY' => 'Thu',
        'FRIDAY' => 'Fri',
        'SATURDAY' => 'Sat',
        'SUNDAY' => 'Sun',
    ],
    'PropertyCostTypeEnum' => [
        'INITIAL' => 'Initial Cost',
        'MONTHLY' => 'Monthly Cost',
    ],
    'PropertyBpTypeEnum' => [
        'INCOME' => 'Income',
        'EXPENDITURE' => 'Expenditure',
    ],
    'PropertyTenantCostBpTypeEnum' => [
        'INCOME' => 'Income',
        'EXPENDITURE' => 'Expenditure',
    ],
    'PropertyTenantCostTypeEnum' => [
        'INITIAL' => 'Initial Cost',
        'MONTHLY' => 'Monthly Cost',
    ],
    'PropertyOwnerCostBpTypeEnum' => [
        'INCOME' => 'Income',
        'EXPENDITURE' => 'Expenditure',
    ],
    'PropertyOwnerCostTypeEnum' => [
        'INITIAL' => 'Initial Cost',
        'MONTHLY' => 'Monthly Cost',
    ],
    'PropertyRoomParkingTypeEnum' => [
        'ARRANGED_MANAGEMENT_COMPANY' => 'Arranged Management By Company',
        'ARRANGED_COMPANY' => 'Arranged By Company',
    ],
    'PropertyRoomParkingCertificateTypeEnum' => [
        'ARRANGED_MANAGEMENT_COMPANY' => 'Arranged Management By Company',
        'ARRANGED_COMPANY' => 'Arranged By Company',
    ],
    'PropertyRoomParkingSpaceEnum' => [
        'NONE' => 'None',
        'ON_SITE' => 'On Site',
        'NEARBY_AVAILABLE' => 'Nearby Available',
    ],
    'PropertyRoomOwnerContractStatusEnum' => [
        'UNDER_CONTRACT' => 'Under Contract',
        'CONTRACT_EXPIRED' => 'Contract expired'
    ],
    'MaintenanceStatusEnum' => [
        'NOT_PROCESSED' => 'Not processed',
        'IN_PROCESSING' => 'In progress',
        'PROCESSED' => 'Processed',
    ],

    'MaintenanceCostKind' => [
        'BILLING' => 'Billing',
        'PAYMENT' => 'Payment',
    ],

    'RoomTypeEnum' => [
        'ROOM' => 'Room',
        'KITCHEN' => 'K (Kitchen)',
        'DK' => 'DK (Dining Kitchen)',
        'SDK' => 'SDK (Service Room/Dining Kitchen)',
        'LDK' => 'LDK (Living/Dining Kitchen)',
        'SLDK' => 'SLDK (Service Room/Living/Dining Kitchen)',
    ],
    'PostTypeEnum' => [
        'NONE' => 'None',
        'DIAL' => 'Dial',
        'KEY' => 'Key',
    ],
    'RoomTypeCode' => [
        'ROOM' => 'Room',
        'KITCHEN' => 'K',
        'DK' => 'DK',
        'SDK' => 'SDK',
        'LDK' => 'LDK',
        'SLDK' => 'SLDK',
    ],
    'YellowcardPetEnum' => [
        'NO' => 'NO',
        'YES' => 'YES',
        'NEGOTIABLE' => 'NEGOTIABLE',
    ],
    'TransactionTypeEnum' => [
        'PURCHASE' => 'PURCHASE',
        'RENT' => 'RENT',
    ],
    'OwnerAgentEnum' => [
        'OWNER' => 'OWNER',
        'AGENCY' => 'AGENCY',
    ],
    'KitchenStoveTypeEnum' => [
        'GAS' => 'GAS',
        'ELECTRIC' => 'ELECTRIC',
    ],
    'DecisionTypeEnum' => [
        'NO' => 'NO',
        'YES' => 'YES',
    ],
    'CheckStatusEnum' => [
        'NO_CHECK' => 'no check',
        'CHECK' => 'check',
    ],
    'MilitaryInspectionApplicationTypeEnum' => [
        'NEW' => 'New',
        'RENEWAL' => 'Renewal',
        'RE_INSPECTION' => 'Re-Inspection',
    ],
    'ApplicationTypeEnum' => [
        'COMPANY' => 'Company',
        'OWNER' => 'Owner',
    ],
    'MilitaryDecisionTypeEnum' => [
        'NO' => 'No',
        'YES' => 'Yes',
    ],
    'maintenance_cost_search' => [
        'owner' => 'Owner',
        'tenant' => 'Tenant',
        'supplier' => 'Supplier'
    ],
    'PropertyImageTypeEnum' => [
        'IMAGE' => 'Image',
        'VIDEO' => 'Video',
    ],
    'TenantNationalityEnum' => [
        'AMERICA_KA' => 'America Ka',
        'AMERICA_CI' => 'America Ci',
        'JAPAN' => 'Japan',
    ],
    'TenantResidenceStatusEnum' => [
        'BEFORE_MOVING_IN' => 'Before Moving In',
        'CURRENTLY_MOVING_IN' => 'Currently Moving In',
        'REMOTE' => 'Remote',
    ],
    'RoomImageTypeEnum' => [
        'IMAGE' => 'Image',
        'VIDEO' => 'Video',
    ],
    'ExpenseItemTaxRateEnum' => [
        'RATE_10_PERCENT' => '10%',
        'RATE_8_PERCENT_REDUCED' => '8%（Reduced tax rate）',
        'RATE_8_PERCENT' => '8%',
        'RATE_0_PERCENT' => '0%',
    ],
    'ApiClientStatusEnum' => [
        'DISABLED' => 'Disabled',
        'ENABLED' => 'Enabled',
    ],
    'BillInvoiceAddFlagEnum' => [
        'NOT_REFLECTED' => 'Not Reflected',
        'REFLECTED' => 'Reflected',
    ],
    'InvoiceAddFlagEnum' => [
        'NOT_REFLECTED' => 'Not reflected',
        'REFLECTED' => 'reflected',
    ],
    'EndedReasonTypeEnum' => [
        'TRANSFER_ANOTHER_COMPANY' => 'Transfer To Another Company',
        'RETURN_TO_OWNER' => 'Return To Owner',
        'CHANGE_OF_OWNER' => 'Owner Changed',
        'PLAN_FOR_SALE' => 'Plan For Sale',
        'OTHER' => 'Other',
    ],
    'InspectionEnum' => [
        'NO' => 'NO',
        'YES' => 'YES',
    ],
    'PropertyRoomFurnishedEnum' => [
        'NO' => 'NO',
        'YES' => 'YES',
    ],
    'FixtureEnum' => [
        'BATH_AND_TOILET' => 'Bath and toilet separated',
        'BATH_TUB' => 'Bath tub',
        'INTERNET' => 'Internet',
        'ELEVATOR' => 'Elevator',
        'STORAGE' => 'Storage',
        'SECURITY' => 'Security system',
    ],
    'EnvironmentEnum' => [
        'YARD' => 'Yard',
        'PATIO' => 'Patio',
        'BALCONY' => 'Balcony',
        'BBQ_OK' => 'BBQ OK',
        'PET_FRIENDLY' => 'Pet Friendly',
        'FAMILY_FRIENDLY' => 'Family Friendly',
    ],
    'LocationEnum' => [
        'OCEAN_VIEW' => 'Ocean View',
        'CLOSE_TO_PARK' => 'Close to Park',
        'CLOSE_TO_BEACH' => 'Close to Beach',
        'SUPERMARKET' => 'Super Market',
        'CONVERIENCE_STORE' => 'Converience Store',
        'QUIET_AREA' => 'Quiet Area',
    ],
    'ParkingSpaceTypeEnum' => [
        'ROOF' => 'Roof',
        'GARAGE' => 'Garage',
        'ENCLOSED' => 'Enclosed',
        'MECHANICAL' => 'Mechanical',
    ],
    'ParkingSpaceLineEnum' => [
        'VERTICAL' => 'Vertical',
        'PARALLEL' => 'Parallel',
        'MECHANICAL' => 'Mechanical',
    ],

    'ApplianceTypeEnum' => [
        'APPLIANCES_FURNITURE' => 'Appliances / Furniture',
        'CONNECTING_REFRIGERATOR' => 'Refrigerator',
        'CONNECTING_WASHER' => 'Washer',
        'CONNECTING_DRYER' => 'Dryer',
        'CONNECTING_STOVE' => 'Stove',
        'OVEN' => 'Oven',
        'DISHWASHER' => 'Dishwasher',
        'MICROWAVE' => 'Microwave',
        'IH_STOVE' => 'IH Stove',
        'AIR_CONDITIONING' => 'Air Conditioning',
        'HEATING' => 'Heating',
    ],

    // breadcrumbs
    'breadcrumbs' => [
        'account' => [
            'index' => 'Account',
            'list' => 'Account list',
        ],
        'owner' => [
            'index' => 'Owner Management',
            'list' => 'Owner List',
            'detail' => 'Owner Details'
        ],
        'expense_item' => [
            'index' => 'Expense item',
            'list' => 'Expense item list',
        ],
        'areas' => [
            'index' => 'Area Management',
            'list' => 'Area List',
        ],
        'supplier' => [
            'index' => 'Suppliers',
            'list' => 'Supplier List',
        ],
        'tenant' => [
            'index' => 'Tenant management',
            'list' => 'Tenant list',
            'detail' => 'Tenant details'
        ],
        'property' => [
            'index' => 'Object Management',
            'list' => 'Property List',
            'detail' => 'Property Detail'
        ],
        'setting' => [
            'index' => 'Settings',
            'list' => 'Settings List',
        ],
        'holiday' => [
            'index' => 'Holiday',
            'list' => 'Holiday List',
        ],
        'blog_article' => [
            'index' => 'Blog Article',
            'list' => 'Blog Article List',
        ],
    ],

    'confirm_update_hp_room' => [
        'button_publish' => 'Publish',
        'button_no_publish' => 'Make Private',
        'text_msg_publish' => 'This will be published on the website. Is that okay?',
        'text_msg_no_publish' => 'Set to private from HP. Is that OK?',
    ],

    // screens
    'screens' => [
        'dashboard' => [
            'manage_property' => 'Manage property (room)',
            'tenants' => 'Tenants',
            'payment_past_due_date' => 'Payment past due date',
            'overdue_payment' => 'Overdue payments',
            'vacant_property' => 'Vacancies',
            'list' => 'List',
            'maintenance_property_title' => 'Property currently undergoing maintenance',
            'tenant_property_title' => '6 months before lease expiration',
            'date_expired' => 'Fixed term lease expired',
            'property_title' => '3 months before the 2020 inspection deadline',
            'deadline' => '	Deadline',
            'waiting_move_out' => 'Waiting for move-out',
            'under_military_inspection' => 'Under military inspection',
            'cleaning' => 'Cleaning',
            'occupancy_rate' => 'Occupancy rate',
            'tenant_list' => 'Tenant list',
            'vacancy_list' => 'Vacancy list',
            'paid' => 'Paid',
            'unpaid' => 'Unpaid',
            'payment_rate' => 'Payment rate',
            'payment_rate_for_month' => 'Payment rate for the month',
            'payment_rate_for_year' => 'Current year deposit rate',
            'paid_list' => 'Paid list',
            'unpaid_list' => 'Unpaid list',
        ],
        'account' => [
            'index' => [
                'page_title' => 'Account list',
                'search' => [
                    'title' => 'Account search',
                    'name' => 'Account name (partial match)',
                ],
                'register' => 'Account registration',
                'edit' => 'Account Edit',
                'locked' => 'Locked',
            ],
        ],
        'blog_article' => [
            'index' => [
                'page_title' => 'Blog Article List',
                'search' => [
                    'title' => 'Blog Article Search',
                ],
                'register' => 'Blog Article Registration',
                'edit' => 'Blog Article Edit',
            ],
        ],
        'login_twofactor' => [
            'title' => 'Please enter the authentication code sent to your email address.',
            'btn_resend_code' => 'Resend the authentication code.',
            'btn_back_to_login' => 'Back to Login',
            'modal' => [
                'title' => 'Resend Authentication Code',
                'msg' => 'We will resend the authentication code. Are you sure?'
            ]
        ],
        'owner' => [
            'index' => [
                'page_title' => 'Owner List',
                'search' => [
                    'title' => 'Owner Search',
                    'owner_name' => 'Owner Name (partial match)',
                    'owner_id' => [
                        'title' => 'Owner ID (partial match) *Enter after "L-".',
                        'placeholder' => 'Enter after "L-"'
                    ],
                    'property_name' => 'Property Name (partial match)',
                    'owner_address' => [
                        'title' => 'Address (partial match) *Enter city or town.',
                        'placeholder' => 'Enter city or town'
                    ]
                ]
            ],
            'detail' => [
                'page_title' => 'Owner Details',
                'name' => 'Mr./Mrs.',
                'tab_list' => [
                    'owner_info' => 'Owner Information',
                    'owner_properties' => 'Owned Properties',
                    'other_notes' => 'Other Notes'
                ],
                'owner_properties' => [
                    'contract_period' => 'Contract period'
                ],
                'delete_owner_button' => 'Delete Owner'
            ],
            'create' => [
                'title' => 'Register Owner',
                'post_code' => 'PostCode',
                'post_code_title' => 'Post code (with hyphens)',
                'tel_title' => 'Tel (with hyphens)',
                'pref_id_title' => 'Address 1 (Prefecture)',
                'address_title' => 'Address 2 (City, Ward, Town, etc.)'
            ],
            'edit' => [
                'title' => 'Owner Information',
                'edit_memo_title' => 'Other Notes',
                'post_code_title' => 'Post code (with hyphens)',
                'tel_title' => 'Tel (with hyphens)'
            ]
        ],
        'expense_item' => [
            'index' => [
                'page_title' => 'Expense Item List',
                'search' => [
                    'title' => 'Expense item search',
                    'name' => 'Expense item name (partially consistent)',
                ],
                'register' => 'Expense item registration',
                'edit' => 'Edit expense item',
            ],
        ],
        'areas' => [
            'index' => [
                'page_title' => 'Area List',
                'search' => [
                    'title' => 'Area Search',
                    'name' => 'Area Name (partial match)',
                ],
                'register' => 'Area Registration',
                'edit' => 'Area Edit',
            ],
        ],
        'supplier' => [
            'index' => [
                'page_title' => 'Supplier List',
                'search' => [
                    'title' => 'Business Partner Search',
                    'customer_name' => 'Customer Name (Partial Match)',
                ],
                'register' => 'Business Partner Registration',
                'edit' => 'Supplier Edit',
            ],
            'create' => [
                'post_code' => 'Post code',
                'code' => 'Postcode',
            ],
        ],
        'setting' => [
            'index' => [
                'setting_project' => 'Setting Item',
                'setting_value' => 'Setting Value',
                'company_name' => 'Company Name',
                'address' => 'Address',
                'tel' => 'TEL',
                'stamp_url' => 'Company Seal Image',
                'email_address' => 'Email Address',
                'account_info1' => 'Account Information ①',
                'account_info2' => 'Account Information ②',
                'invoice_regis_number' => 'Invoice Registration Number',
                'tenant_billing_due_date' => 'Tenant Billing Default Due Date',
                'tenant_payment_due_date' => 'Tenant Payment Default Due Date',
                'owner_billing_due_date' => 'Owner Billing Default Due Date',
                'owner_payment_due_date' => 'Owner Payment Default Due Date',
                'establish' => 'Establish',
                'president_name' => 'President Name',
                'business_hour' => 'Business Hour',
                'service' => 'Service',
                'license' => 'Authorization/License',
                'lang_support' => 'Language Support',
                'site_url' => 'Website URL',
                'image_url' => 'Image',
            ],
            'update' => [
                'pl_company_name' => 'Property Area Name',
                'pl_invoice_number' => 'Account Number',
            ]
        ],
        'holiday' => [
            'index' => [
                'page_title' => 'Holiday List',
                'close_date' => 'Holiday Date',
                'holiday_name' => 'Holiday Name',
                'edit' => 'Edit',
                'delete' => 'Delete',
                'register' => 'Registration On Holidays',
                'year' => 'Year',
            ],
           'placeholder' => [
               'holiday_name' => 'Holiday Name',
           ],
            'edit' => 'Edit'
        ],
        'tenant' => [
            'index' => [
                'page_title' => 'Tenant List',
                'search' => [
                    'title' => 'Tenant Search',
                    'name' => 'Tenant Name (Partial Match)',
                    'view_id' => 'Tenant ID (Partial Match) ※ Enter after "T-".',
                    'property_name' => 'Property Name (Partial Match)',
                    'ph_view_id' => 'Enter after "T-"',
                    'ph_property_name' => 'Property Name',
                    'movein_date' => 'Move-in date',
                    'before_moving_in' => 'Before Moving In',
                    'currently_moving_in' => 'Currently Moving In',
                    'remote' => 'Remote',
                    'residence_status'=>'Residence Status',
                    'rent_payment_type'=>'Rent Payment Type',
                ],
                'register' => 'Tenant Registration',
//        'edit' => ' Details',
            ],
            'detail' => [
                'page_title' => 'Tenant Details',
                'title_name' => 'Tenant Name',
                'title_name_kana' => 'Name Kana',
                'tab_list' => [
                    'tenant_info' => 'Tenant Information',
                    'tenant_properties' => 'Tenant Properties',
                    'tenant_service' => 'Other Notes'
                ],
                'view_id' => 'ID',
                'cust_id' => 'Cust ID',
                'name' => 'Tenant Name',
                'rank' => 'Rank',
                'branch' => 'BRANCH',
                'service' => 'SERVICE',
                'base' => [
                    'name' => 'Work Location'
                ],
                'building' => 'WORKING BASE BUILDING #',
                'organization' => 'ORGANIZATION',
                'commander_name' => 'COMMANDER’S NAME',
                'commander_tel' => 'COMMANDER’S TEL',
                'supervisor_name' => 'SUPERVISOR’S NAME',
                'supervisor_tel' => 'SUPERVISOR’S TEL',
                'rent_payment_type' => 'Rent Payment',
                'zip' => 'Postal Code',
                'pref' => [
                    'name' => 'Address 1 (Prefecture)'
                ],
                'address' => 'Address 2 (City/Town/Village)',
                'tel' => 'TEL',
                'at_work_tel' => 'Work TEL',
                'email' => 'Email Address',
                'email_secondary' => 'Secondary Email Address',
                'military_address' => 'MILITARY ADDRESS (APO)',
                'social_security_number' => 'SOCIAL SECURITY NUMBER',
                'car_number' => 'Vehicle Number',
                'date_of_birth' => 'Date of Birth',
                'housemate_memo' => 'Housemate Notes',
                'emergency_contact_memo' => 'Emergency Contact Notes',
                'pet_info' => 'Pet Notes',
                'pet_available' => 'Pet Available',
                'pet_large_dog_count' => 'Large Dog',
                'pet_small_dog_count' => 'Small Dog',
                'pet_cat_count' => 'Cat',
                'pet_other_count' => 'Other',
                'bank_name' => 'Bank Name',
                'bank_branch_name' => 'Branch Name',
                'bank_account_number' => 'Account Number',
                'bank_account_type' => 'Account Type',
                'bank_account_name' => 'Account Holder',
                'memo' => 'Memo',
                'delete_tenant_button' => 'Delete Tenant'
            ],
            'edit' => [
                'title' => 'Tenant Information',
                'edit_memo_title' => 'Other Notes'
            ],
            'tenants_properties' => [
                'view_id' => 'ID',
                'name' => 'Property Name',
                'room_number' => 'Room No',
                'status' => [
                    1 => 'Under Contract',
                    9 => 'Contract Ended',
                    2 => 'Management Ended',
                ],
                'contract_date' => 'Contract Period',
                'tenant_memo' => 'Tenant Memo',
                'yearly' => 'Yearly',
            ],
            'joint_guarantor' => [
                'title' => 'Joint Guarantor',
                'name' => 'Name',
                'name_kana' => 'Kana',
                'type' => 'Relationship',
                'tel' => 'TEL',
                'email' => 'Email Address',
                'ssn' => 'SSN',
            ],
            'housemate' => [
                'title' => 'Housemate',
                'name' => 'Name',
                'name_kana' => 'Roommate',
                'type' => 'Relationship',
                'tel' => 'TEL',
                'email' => 'Email Address',
                'age' => 'Age',
            ],
            'emergency' => [
                'title' => 'Emergency Contact',
                'name' => 'Name',
                'name_kana' => 'Kana',
                'type' => 'Relationship',
                'zip' => 'Address',
                'tel' => 'TEL',
                'email' => 'Email Address',
            ],
        ],
        'property' => [
            'index' => [
                'page_title' => 'Property List',
                'search' => [
                    'title' => 'Property Search',
                    'object_name' => 'Object name (partially identical)',
                    'id' => 'ID (same as above)',
                    'tenant_cost_amount' => 'Price',
                    'pet_status' => 'Pet',
                    'area_name' => 'Area',
                    'movein_status' => 'Status',
                    'ended_reason_type' => 'Ended Reason',
                    'number_of_bed' => 'Number of beds',
                    'number_of_toilet' => 'Number of toilets',
                    'type' => 'Type',
                    'room_count' => 'Layout',
                    'placeholder' => [
                        'object_name' => 'Object name',
                        'id' => 'ID',
                    ],
                    'floor_plan' => 'Floor plan',
                ],
                'register' => 'Property registration',
                'area_name' => 'Area',
                'room_count' => 'Layout',
                'pet_status' => 'Pets',
                'tenant_cost_amount' => 'Rent',
                'movein_status' => 'Status',
                'floor_plan' => 'Floor plan',
            ],
            'create' => [
                'management_company' => 'Management company name',
                'supplier' => "Entrepreneur's name",
                'city' => 'City/town name',
                'add' => 'addition',
                'option' => 'option',
            ],
            'detail' => [
                'page_title' => 'Property Detail',
                'title' => 'ALPHA STATES CHATAN HILLS',
                'delete_button' => 'Delete Property',
                'delete_room' => 'Delete Room',
                'tenant_property' => [
                    'title_edit' => 'Edit',
                    'tenant' => 'Tenant',
                    'change_text' => 'Change',
                    'title_create' => 'Registration',
                    'register' => 'Tenant Registration',
                    'btn_mark_move_out' => 'Mark as moved out',
                    'msg_mark_move_out' => 'We will mark you as having moved out. Is this OK?',
                    'move_out' => [
                        'title' => 'Move-Out Process',
                        'sub_title' => 'Are you sure you want to execute the move-out process?',
                        'plan_moveout_date' => 'Planned Move-Out Date',
                        'moveout_date' => 'Move-Out Date',
                        'accrual_date' => 'Accrual Date',
                        'period_date' => 'Period Date',
                        'msg_confirm' => 'You will be put on hold to leave. Are you sure?',
                        'fly_out_date' => 'Fly Out日',
                    ],
                    'btn_to_move_in' => 'I will move in',
                    'btn_mark_move_in' => 'Do it while you are in',
                    'msg_mark_move_in' => 'I will put it back in your tenancy. Is that OK?',
                ],
                'property_information' => [
                    'zip' => 'Post code',
                    'address' => 'Address',
                    'water_channel_photothermal' => 'Water channel photothermal',
                    'businesses_municipalities' => 'Businesses and municipalities',
                    'management_company_name' => 'Management company name',
                    'email_address' => 'Email address',
                ],
                'room' => [
                    'name_tab' => [
                        'room_information' => 'Room Information',
                    ],
                    'room_information' => [
                        'type' => 'Type',
                        'number_of_bed' => 'Number of Beds',
                        'number_of_toilet' => 'Number of Toilets',
                        'room_size' => 'Room Size',
                        'room' => 'Room',
                        'size' => 'Size',
                        'entrance_door_master' => 'Entrance Door (Master)',
                        'entrance_door_copy' => 'Entrance Door (Copy)',
                        'parking' => 'Parking',
                        'garbage_dump' => 'Garbage Dump',
                        'rubbish' => 'Rubbish',
                        'how_to_serve' => 'How to Dispose',
                        'floor_plan' => 'Floor plan',
                        'floor_plan_note' => 'Floor plan notes',
                        'exclusive_area' => 'Exclusive area',
                        'mailbox' => 'Mailbox',
                        'mailbox_note' => 'Mailbox Notes',
                        'key' => 'Key',
                        'place' => 'Place',
                        'master_key' => 'Tenants',
                        'office' => 'Office',
                        'total' => 'Total',
                        'main' => 'Building Entrance (Master)',
                        'back_door' => 'back door',
                        'other' => 'others',
                        'owner_history' => 'Owner history',
                        'contract' => 'contract',
                        'end' => 'end',
                        'owner_change' => 'Owner change',
                        'confirm_end_contract' => "I'm going to terminate the contract. Are you sure?",
                        'tenants' => 'tenants',
                        'book' => 'book',
                        'main_copy' => 'Building Entrance (Copy)',
                        'key_number' => 'Key Number',
                        'master' => 'Master',
                        'copy' => 'Copy',
                        'back' => 'Back',
                        'ended_reason_type' => 'Ended Reason',
                        'owner_change_modal' => [
                            'title' => 'Owner Change',
                            'owner' => 'Owner',
                        ],
                        'edit' => [
                            'title' => 'equipment',
                            'dial_number' => 'Dial number',
                            'owner_contract_date' => 'Contract date',
                            'building_entrance_master' => 'Building entrance (master)',
                            'building_entrance_copy' => 'Building entrance (copy)',
                            'entrance_door_master' => 'Entrance door (master)',
                            'entrance_door_copy' => 'Entrance door (copy)',

                        ],
                        'tenant_information_sheet' => 'Tenant Information Sheet',
                        'number_of_parking' => 'Number of parking',
                        'parking_space_type' => 'Parking space type',
                        'parking_space_line' => 'Parking space line',
                        'parking_type' => 'Parking type',
                        'parking_space' => 'Parking space',
                        'parking_number' => 'Parking number',
                        'parking_certificate_type' => 'Parking certificate type',
                        'parking_certificate_comment' => 'Parking certificate comment',
                        'inspection' => 'INSPECTION',
                        'fixtures' => 'Fixtures',
                        'appliances' => 'Appliances',
                        'high_school' => 'High school',
                        'middle_school' => 'Middle school',
                        'elementary_school' => 'Elementary school',
                        'environment' => 'Environment',
                        'location' => 'Location',
                        'hp_title' => 'Title For HP',
                        'number_of_floors' => 'Number Of Floors',
                        'bath_room_count' =>'BATH ROOMS',
                        'furnished' => 'Furnished',
                        'available_date' => 'Available Date',
                    ],
                    'yellow_card' => [
                        'title' => 'YellowCard',
                        'story_storage' => 'STORY & STORAGE',
                        'security_deposit' => 'REGISTERED RENT NOT TO EXCEED & SECURITY DEPOSIT',
                        'deposit' => 'DEPOSIT',
                        'other' => 'OTHER',
                        'phone_email' => 'PHONE & EMAIL ADDRESS',
                        'room' => 'ROOM',
                        'photo_check' => 'I HAVE SUBMITTED A MINIMUM OF 5 PHOTOS,BUT NO MORE THAN 10 FOR THIS LISTING',
                        'unit_built_mmddyy' => 'UNIT BUILT DATE',
                        'rent' => 'RENT',
                        'emergency'=>'EMERGENCY',
                        'email'=>'EMAIL',
                        'date'=>'DATE',
                        'water_label' => 'WATER',
                        'net_sqft' => 'SQFT',
                        'pets' => [
                            'type' => 'TYPE',
                            'pets_max_weight' => 'WEIGHT',
                            'pets_type_not_allowed' => 'TYPE NOT ALLOWED',
                        ],
                        'dist_from' => [
                            'miles' => 'MILES',
                            'time' => 'TIME',
                        ],
                        'bath' => [
                            'title' => 'BATH',
                            'bath_comment' => 'Full comment',
                            'option' => [
                                'bath_full' => 'FULL',
                                'bath_12' => '1/2',
                                'bath_jacuzzi' => 'JACUZZI',
                                'bath_washlet' => 'WASHLET',
                            ],
                        ],
                        'kitchen' => [
                            'title' => 'KITCHEN',
                            'stove' => 'STOVE',
                            'stove_type' => 'STOVE TYPE',
                            'option_1' => [
                                'kitchen_connection_for_stove' => 'CONNECTION FOR STOVE',
                                'kitchen_refrig' => 'REFRIG',
                                'kitchen_connection_for_refrig' => 'CONNECTION FOR REFRIG',
                            ],
                            'option_2' => [
                                'kitchen_oven' => 'OVEN',
                                'kitchen_microwave' => 'MICROWAVE',
                                'kitchen_dishwasher' => 'DISHWASHER',
                                'kitchen_disposal' => 'DISPOSAL',
                            ],
                        ],
                        'dod_school_district' => [
                            'title' => 'DOD SCHOOL DISTRICT',
                            'highschool' => 'HIGHSCHOOL',
                            'middle' => 'MIDDLE',
                            'elementary' => 'ELEMENTARY',
                        ],
                        'washer_dryer' => [
                            'title' => 'WASHER & DRYER',
                            'option_1' => [
                                'washer' => 'WASHER',
                                'connection_for_washer' => 'CONNECTION FOR WASHER',
                                'connection_for_dryer' => 'CONNECTION FOR DRYER',
                            ],
                            'option_2' => [
                                'gas_dryer' => 'GAS DRYER',
                                'electric_dryer' => 'ELECTRIC DRYER',
                            ],
                        ],
                        'garage_parking' => [
                            'title' => 'GARAGE & PARKING',
                            'option' => [
                                'garage' => 'GARAGE',
                                'parking_space' => 'PARKING SPACE',
                                'other' => 'OTHER',
                            ],
                        ],
                        'water' => [
                            'title' => 'WATER HEATER',
                            'option' => [
                                'water_heater_kerosene' => 'KEROSENE',
                                'water_heater_gas' => 'GAS',
                                'water_heater_electric' => 'ELECTRIC',
                                'water_heater_all_electric' => 'ALL ELECTRIC',
                            ],
                        ],
                        'air_cond_heater' => [
                            'title' => 'AIR COND/HEATER',
                            'option' => [
                                'air_cond_heater_central' => 'CENTRAL',
                                'air_cond_heater_window' => 'WINDOW',
                                'air_cond_heater_wall_mounted' => 'WALL MOUNTED',
                            ],
                        ],
                        'utilities_paid_by' => [
                            'title' => 'UTILITIES PAID BY',
                            'option' => [
                                'utilities_paid_by_landlord' => 'LANDLOAD',
                                'utilities_paid_by_tenant' => 'TENANT',
                            ],
                        ],
                        'community_information' => [
                            'title' => 'COMMUNITY INFORMATION',
                            'option_1' => [
                                'community_information_fitness' => 'FITNESS CENTER',
                                'community_information_clubhouse' => 'CLUB HOUSE',
                                'community_information_waterfront' => 'WATERFRONT',
                            ],
                            'option_2' => [
                                'community_information_playground' => 'PLAY GROUND',
                                'community_information_waterview' => 'WATER VIEW',
                                'community_information_community_courts' => 'COMMUNITY COURTS',
                            ],
                        ],
                        'features' => [
                            'title' => 'FRATURES',
                            'option_1' => [
                                'features_utility_shed' => 'UTILITY SHED',
                                'features_outside_storage' => 'OUTSIDE STORAGE',
                                'features_office_extraroom' => 'OFFICE/EXTRA ROOM',
                            ],
                            'option_2' => [
                                'features_patio' => 'PATIO',
                                'features_fenced_yard' => 'FENCED YARD',
                                'features_balcony' => 'BALCONY',
                            ],
                            'option_3' => [
                                'features_garage_door_opener' => 'GARAGE DOOR OPENER',
                                'features_pool' => 'POOL',
                                'features_internet_ready' => 'INTERNET READY',
                            ],
                            'option_4' => [
                                'features_window_coverings' => 'WINDOW COVERINGS',
                                'features_skylights' => 'SKYLIGHTS',
                            ],
                        ],
                        'safety_security' => [
                            'title' => 'SAFETY & SECURITY',
                            'option_1' => [
                                'safety_alarm_system' => 'ALARM SYSTEM',
                                'safety_gate_access' => 'GATE ACCESS',
                            ],
                            'option_2' => [
                                'safety_door_bell' => 'SECURITY DOOR BELL',
                                'safety_smoke_detector' => 'SMOKE DETECTOR',
                            ],
                        ],
                        'signature' => [
                            'type_of_date' => 'DATE（MM/DD/YY）',
                        ],
                    ],
                    'military_inspection_applications' => [
                        'examination_date' => 'Examination date',
                        'form' => [
                            'title' => 'Military application form',
                            'property_address' => 'Property address',
                            'preferred_date' => 'Preferred date for military testing',
                            'first_time' => 'First Time',
                            'retest' => 'Retest',
                            'enter_and_exit' => 'How to enter and exit',
                            'key_box_code' => 'Key box code',
                            'pin_number' => 'Pin Number',
                            'zenrin_map' => 'Zenrin Map (Property and Parking Layout)',
                            'certificate' => 'Certified copy of the registry (certificate of all details)',
                            'compliance_certificate' => 'Lead paint/asbestos/Fire prevention law compliance certificate',
                            'building_inspection' => "Building inspection report/floor plan/architect's license",
                            'notice_eviction' => 'Notice of Eviction/Eviction',
                            'documents_proving_repairs' => 'Documents proving repairs',
                            'image' => '5-10 photos to post',
                        ]
                    ],
                    'update_movein_status' => [
                        'title' => 'Change Status',
                        'msg_confirm' => 'Are you sure you want to change the status?',
                    ],
                ],
            ],
            'edit' => [
                'title' => 'Detail Information',
                'year' => 'year',
                'ping' => 'ping',
                'floor' => 'Floor',
                'pet_detail' => 'Pet Detail'
            ],
        ],
        'property_room' => [
            'create' => [
                'title' => 'Add item',
                'room_no' => 'Room number',
                'tenant' => 'Tenant',
                'owner' => 'Owner',
                'owner_name' => 'Owner name',
                'option' => 'Choice',
            ],
        ],
        'income' => [
            'create' => [
                'title' => 'Add item'
            ],
            'edit' => [
                'title' => 'Edit item',
            ],
            'room_no' => 'Room No',
            'project' => 'Item',
            'amount' => 'Amount',
            'remarks' => 'Remarks',
            'JPY' => 'JPY',
            'no_expenditure_item' => 'No expense items.',
            'no_income_item' => 'No income items.',
            'total_income' => 'Total income',
            'total_expenditure' => 'Total Expenditure',
            'income_expenditure' => 'Income - Expenditure',
            'consumption_tax' => 'VAT',
        ],
        'room_billing_list_tab' => [
            'btn_create_billing' => 'Create Billing Details',
            'index' => [
                'btn_search' => 'Search',
            ],
            'detail' => [
                'paid_title' => 'Paid',
                'unpaid_title' => 'Unpaid',
                'due_date' => 'Due Date',
                'btn_csv_download' => 'Billing Details',
                'btn_invoice_pdf_download' => 'Official Receipt',
                'status_change' => 'Status Change',
            ],
            'edit' => [
                'title' => 'Edit',
            ],
        ],

        'room_payment_list_tab' => [
            'btn_create_payment' => 'Create Payment Details',
            'detail' => [
                'paid_title' => 'Paid',
                'unpaid_title' => 'Unpaid',
                'btn_csv_download' => 'Payment Details',
            ],
        ],

        'utilities' => [
            'create' => [
                'title' => 'Register',
            ],
            'edit' => [
                'title' => 'Edit',
                'supplier' => 'Supplier',
            ],
            'detail' => [
                'supplier' => 'Supplier',
                'contact' => 'Contact',
                'billing_address' => 'Billing Address',
            ],
            'index' => [
                'search' => 'Search',
                'supplier_id1' => 'Other Billing Address 1',
                'supplier_id2' => 'Other Billing Address 2',
                'supplier_id3' => 'Other Billing Address 3',
                'supplier_id4' => 'Other Billing Address 4',
                'supplier_id5' => 'Other Billing Address 5',
                'link_detail_payment' => 'Payment Details Reflected',
                'txt_detail_payment' => 'Reflected in Payment Details',
            ],
            'amount' => 'Amount',
            'JPY' => 'Yen',
            'tab' => [
                'electric' => 'Electricity',
                'gas' => 'Gas',
                'water' => 'Water',
                'trash' => 'Trash',
            ],
            'txt_request_detail' => 'Billing Details',
            'btn_reflect' => 'Reflect',
        ],
        'property_room_utility_cost' => [
            'can_be' => 'Available',
            'none' => 'None',
            'tenant' => 'Tenant',
            'owner' => 'Owner',
            'meter' => 'meter',
            'm3' => '㎥',
            'amount' => 'amount',
        ],
        'property_room_owner' => [
            'placeholder_search' => 'Room No or Owner Name',
            'owner_information' => [
                'title' => 'Owner Information',
                'room_no' => 'Room No'
            ],
            'payment_list' => [
                'title' => 'Payment List'
            ],
            'billing_list' => [
                'title' => 'Billing List'
            ],
            'payment_setting' => [
                'title' => 'Rent Settings'
            ],
            'other_note' => [
                'title' => 'Other Notes',
                'placeholder_text' => 'Other Memo'
            ],
        ],

        'room_rent_setting_tab' => [
            'monthly_tab' => 'Monthly',
            'initial_tab' => 'Initial',
            'monthly_detail' => [
                'set_up_title' => 'Set the monthly recurring flat-rate fees.'
            ],
            'initial_detail' => [
                'set_up_title' => 'Set the initial fees.'
            ]
        ],
        'room_maintenance_tab' => [
            'maintenance_create_update' => [
                'title' => 'Register'
            ],
            'maintenance_cost_create_update' => [
                'title_create' => 'Register',
                'search_name_owner' => 'Owner name',
                'search_name_tenant' => 'Tenant name',
                'search_name_supplier' => 'Supplier name',
                'option' => 'Select',
                'title_edit' => 'Details',
                'billing_address' => 'Billing Address',
                'payment_destination' => 'Payment Destination',
                'property_name' => 'Property Name',
                'btn_billing_csv_download' => 'Billing Details',
                'btn_payment_csv_download' => 'Payment Details',
                'status_change' => 'Status Change',
            ],
            'maintenance_history_create_update' => [
                'title' => 'History'
            ],
            'detail' => [
                'billing_address' => 'Billing Address',
                'payment_destination' => 'Payment Destination',
                'charge' => 'Billing Amount',
                'payment_amount' => 'Payment Amount',
                'edit_title' => 'Edit',
                'del_title' => 'Delete',
                'btn_create_billing' => 'Register Billing Details',
                'btn_create_payment' => 'Register Payment Details',
                'datetime_title' => 'Date and Time',
                'image_title' => 'Image',
                'comment_title' => 'Comment',
                'btn_create_history' => 'Register History'
            ]
        ],
        'other_note_tab' => [
            'edit' => [
                'title' => 'Other Notes',
            ]
        ],
        'file_tab' => [
            'index' => [
                'datetime_upload' => 'Upload Date and Time',
                'file_name' => 'File Name',
            ],
            'upload' => [
                'file' => 'File',
                'file_select' => 'Select File',
            ]
        ],
        'owner_payment_billing_tab' => [
            'btn_create_billing' => 'Create billing details',
            'btn_create_payment' => 'Create payment details',
            'index' => [
                'btn_search' => 'Search',
            ],
            'detail' => [
                'paid_title_payment' => 'Paid',
                'paid_title_billing' => 'Payment',
                'unpaid_title_payment' => 'Unpaid',
                'unpaid_title_billing' => 'Unpaid',
                'due_date' => 'Due date',
                'payment_detail_download' => 'Payment details',
                'request_detail_download' => 'Billing details',
                'status_change' => 'Status change',
                'amount' => 'Amount',
            ],
            'edit' => [
                'title' => 'Edit',
            ]
        ],

        'property_payment_billing_tab' => [
            'btn_create_billing' => 'Create billing details',
            'btn_create_payment' => 'Create payment details',
            'create' => [
                'supplier_name' => 'Customer name',
                'option' => 'Select',
            ],
            'index' => [
                'supplier_name' => 'Customer',
                'btn_search' => 'Search',
            ],
            'detail' => [
                'paid_title_payment' => 'Paid',
                'paid_title_billing' => 'Payment',
                'unpaid_title_payment' => 'Unpaid',
                'unpaid_title_billing' => 'Unpaid',
                'due_date' => 'Due date',
                'payment_detail_download' => 'Payment Details',
                'request_detail_download' => 'Billing Details',
                'status_change' => 'Status Change',
                'amount' => 'Amount',
            ],
            'edit' => [
                'title' => 'Edit',
            ]
        ],

        'monthly_setting_tab' => [
            'title' => 'Payment Settings',
            'client' => 'Business Partner',
            'search' => 'Search',
            'amount' => 'Amount',
            'date_flag' => 'Occurrence Date',
            'supplier_name' => 'Supplier Name',
            'index' => [
                'btn_payment_setting' => 'Payment Settings',
                'btn_invoice_setting' => 'Invoice Settings',
            ],
            'create' => [
            ],
            'payment' => [
                'title' => 'Please set up the payment details that occur regularly every month.',
                'btn_create' => 'Register Payment Settings',
                'limit_flag' => 'Payment Due Date',
            ],
            'invoice' => [
                'title' => 'Please set up the invoice details that occur regularly every month.',
                'btn_create' => 'Register Invoice Settings',
                'limit_flag' => 'Deposit Due Date',
            ],
        ],
        'invoice' => [
            'title' => 'Invoice list',
            'breadcrumbs' => [
                'billing_management' => 'Invoice management',
                'billing_list' => 'Invoice list'
            ],
            'search' => [
                'title' => 'Invoice details search',
                'describe' => '(partial match)',
            ],
            'property_name' => 'Property name',
            'owner_name' => 'Owner name',
            'tenant_name' => 'Tenant name',
            'period_date' => 'Deposit due date',
            'deposit_status' => 'Deposit status',
            'billing_address' => 'Billing address',
            'amount' => 'Amount',
            'status' => 'Status',
            'csv_download' => 'Transaction details CSV download',
            'csv_upload' => 'Payment reconciliation CSV upload',
            'gi_csv_upload' => 'GI Payment reconciliation CSV upload',
            'unpaid_title' => 'Unpaid',
            'paid_title' => 'Payment completed',
            'csv_sample_download' => 'Download Reconciliation CSV Format',
            'gi_csv_sample_download' => 'GI Download Reconciliation CSV Format',
            'import_csv' => [
                'title' => 'Payment',
                'title_detail' => 'Unpaid details',
                'option' => 'Select',
                'due_date' => 'Payment due date',
                'request_amount' => 'Invoice amount',
                'billing_address' => 'Billing address',
                'paid' => 'Payment completed',
                'total' => 'Total',
                'deposit_date' => 'Deposit date',
                'confirm_full_payment' => 'Register. Are you sure?',
                'confirm_partial_payment' => 'Amount does not match. Partial payment. Are you sure?',
                'confirm_gi_partial_payment' => 'The deposit data in the row does not match. Partial deposit will be made. Is that okay?',
                'confirm_over_payment' => 'Payment amount exceeds total amount of invoice. ',
                'row' => 'Row',
                'upload_modal' => [
                    'file' => 'File',
                    'file_select' => 'File selection',
                ],
            ],
            'detail' => [
                'title_create' => 'Details',
                'billing_address' => 'Billing address',
                'property_name' => 'Property name',
                'accrual_date' => 'Date of occurrence',
                'due_date' => 'Due date of payment',
                'deposit_date' => 'Date of payment',
                'btn_billing_csv_download' => 'Billing details',
                'btn_payment_csv_download' => 'Payment details',
                'status_change' => 'Status change',
                'payment_date' => 'Date of payment',
                'btn_invoice_pdf_download' => 'Official Receipt',
            ],
        ],
        'payment' => [
            'title' => 'Payment list',
            'breadcrumbs' => [
                'payment_management' => 'Payment management',
                'payment_list' => 'Payment list'
            ],
            'search' => [
                'title' => 'Payment details search',
                'describe' => '(partial match)',
            ],
            'property_name' => 'Property name',
            'owner_name' => 'Owner name',
            'tenant_name' => 'Tenant name',
            'period_date' => 'Payment due date',
            'deposit_status' => 'Payment status',
            'billing_address' => 'Payment address',
            'amount' => 'Amount',
            'status' => 'Status',
            'csv_download' => 'Transaction details CSV download',
            'csv_upload' => 'Payment reconciliation CSV upload',
            'unpaid_title' => 'Unpaid',
            'paid_title' => 'Paid',
            'journal_download_csv' => 'Journal CSV download',
            'import_csv' => [
                'title' => 'Payment reconciliation',
                'title_detail' => 'Unpaid details',
                'option' => 'Select',
                'due_date' => 'Due date',
                'request_amount' => 'Amount paid',
                'billing_address' => 'Payment address',
                'paid' => 'Date paid',
                'total' => 'Total',
                'upload_modal' => [
                    'file' => 'File',
                    'file_select' => 'Select file',
                ],
                'confirm_full_payment' => 'Register. Are you sure?',
                'confirm_partial_payment' => 'Amount does not match. Partial payment. Are you sure?',
                'confirm_over_payment' => 'The payment amount exceeds the total amount of the payment details.',
            ],
            'detail' => [
                'title_create' => 'Details',
                'billing_address' => 'Payment address',
                'property_name' => 'Property name',
                'accrual_date' => 'Accrual date',
                'due_date' => 'Due date',
                'deposit_date' => 'Payment date',
                'btn_billing_csv_download' => 'Billing details',
                'btn_payment_csv_download' => 'Payment details',
                'status_change' => 'Status change',
                'payment_date' => 'Deposit date',
            ],
        ],
    ],

];
