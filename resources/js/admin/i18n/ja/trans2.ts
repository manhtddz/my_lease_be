export default {
    DISABLED: '無効',
    ENABLED: '有効',

    all: 'すべて',
    required: '必須',
    select_default: '選択してください',
    placeholder_date: '年/月/日',
    placeholder_date_ym: '----年--月',
    choice: '選択',
    selection: '選択',
    JPY: '円',
    zip_code: '〒',
    year: '年',
    month: '月',
    day: '日',
    hash_symbol: '#',
    txt_day: '日',
    post: '帖',
    can: '缶',

    per_page: {
        20: '20件',
        40: '40件',
        50: '50件',
    },
    date: '年/月/日',

    payment_date_type: {
        3: 'すべて',
        1: '未入金',
        2: '入金済',
    },

    payment_date_type2: {
        3: 'すべて',
        1: '未払い',
        2: '支払済',
    },

    deposit_status: {
        1: '未入金',
        2: '入金済',
    },

    deposit_status2: {
        1: '未払い',
        2: '支払済',
    },

    billing_address_type: {
        1: 'すべて',
        2: '入居者',
        3: 'オーナー',
        4: '取引先',
    },

    // button text
    button: {
        regis_move_in: '入居にする',
        regis_all: '選択した明細を一括で登録する',
        search: '検索する',
        clear: 'クリア',
        register: '登録する',
        confirm_close_modal: '保存せずに閉じる',
        edit: ' 編集',
        delete: '削除',
        close: '閉じる',
        cancel_close_modal: '戻る',
        edit_to: '編集する',
        change: '変更する',
        delete_to: '削除する',
        confirm: '確認',
        unlock: '解除する',
        detail: '詳細',
        back_to_index: '一覧に戻る',
        login: 'ログインする',
        logout: 'ログアウト',
        authenticate: '認証する',
        send: '送信する',
        profile: 'アカウント',
        joint_guarantor: '連帯保証人または共同契約者追加',
        add_housemate: '同居人追加',
        add_emergency: '緊急連絡先追加',
        moving_out: '退去',
        moving_in: '入居中に戻す',
        create_room: '部屋登録',
        add_item: '項目追加',
        to_evict: '退去待ちにする',
        quit: '終了する',
        add: '追加',
        remove: '削除',
        download: 'ダウンロード',
        img_select: '画像選択',
        save: '保存する',
        upload: 'アップロード',
        to_upload: 'アップロードする',
        registration: ' 登録',
        status_change: 'ステータス変更',
        help: 'ヘルプ',
        property_room_hp_publish: 'HP掲載中',
        property_room_hp_no_publish: 'HP非掲載',
    },

    confirm_modal: {
        regis_move_in: '入居にします。よろしいですか？',
        register: '登録します。よろしいですか？',
        edit: '編集します。 よろしいですか?',
        delete: '削除します。よろしいですか？',
        unlock: 'ロックを解除します。よろしいですか？',
        paid_billing: '入金済にします。よろしいですか？',
        paid_payment: '支払済にします。よろしいですか？',
        unpaid_billing: '未入金にします。よろしいですか？',
        unpaid_payment: '未払いにします。よろしいですか？',
        reflected_payment: '反映します。よろしいですか？',
        'exit-modal': '保存されていません。よろしいですか？'
    },

    // enum
    UserRoleEnum: {
        ADMIN: 'adminJP',
        MANAGER: 'managerJP',
        EMPLOYEE: 'employeeJP',
    },

    SidebarMenuEnum: {
        DASHBOARD: 'ダッシュボード',
        PROPERTY: '物件管理',
        OWNER: 'オーナー管理',
        TENANT: '入居者管理',
        INVOICE: '請求管理',
        PAYMENT: '支払管理',
        LEASEMART_AI: 'Leasmart AI',
        VARIOUS_SETTINGS: '各種設定',
        ACCOUNT: 'アカウント',
        SUPPLIER: '取引先',
        EXPENSE_ITEM: '費用項目',
        AREA: '物件エリア',
        LOGOUT: 'ログアウト',
        SETTING: '設定',
        HOLIDAY: '休業日',
        BLOG_ARTICLE: 'ブログ記事',
    },

    ApplianceTypeEnum: {
        APPLIANCES_FURNITURE: 'Appliances / Furniture',
        CONNECTING_REFRIGERATOR: 'Refrigerator',
        CONNECTING_WASHER: 'Washer',
        CONNECTING_DRYER: 'Dryer',
        CONNECTING_STOVE: 'Stove',
        OVEN: 'Oven',
        DISHWASHER: 'Dishwasher',
        MICROWAVE: 'Microwave',
        IH_STOVE: 'IH Stove',
        AIR_CONDITIONING: 'Air Conditioning',
        HEATING: 'Heating',
    },

    room_tab_title: {
        tenant_info: '入居者情報',
        room_info: '部屋情報',
        owner: 'オーナー',
        billing_list: '請求一覧',
        payment_list: '支払一覧',
        utility: '水道光熱',
        rent_setting: '家賃設定',
        parking: '駐車場',
        yellow_card: 'YellowCard',
        military: '軍検申請書',
        room_file: 'ファイル',
        room_image: '画像・動画',
        maintenance: 'メンテナンス',
        'resident-demand-seat': '入居者履歴',
        residence_period: '入居期間',
    },

    HpPublicFlagEnum: {
        NOT_LISTED: '非掲載',
        PUBLISH: '掲載',
    },

    AuthRoleEnum: {
        ADMIN: 'ADMIN',
        TRIAL: 'TRIAL',
        MEMBER: 'MEMBER',
    },
    GMOPaymentMethodEnum: {
        CREDIT_CARD: 'クレジットカード',
        BANK_TRANSFER: '銀行振込',
        CONVENIENCE_STORE: 'コンビニ決済',
        AMAZON_PAY: 'Amazon Pay',
        PAYPAY: 'PAYPAY',
        CREDIT_CONTINUATION: 'クレジットカード継続課金を追加',
    },
    BankAccountTypeEnum: {
        NORMAL: '普通',
        CURRENT: '当座',
    },
    ArticleStatusEnum: {
        DRAFT: '下書き',
        PUBLISHED: '公開',
        ARCHIVED: 'アーカイブ',
    },
    ParkingCertificateTypeEnum: {
        ARRANGE_MANAGEMENT_COMPANY: '管理会社手配',
        INTERNAL_ARRANGEMENT: '自社手配',
    },
    ParkingTypeEnum: {
        ARRANGE_MANAGEMENT_COMPANY: 'ARRANGE_MANAGEMENT_COMPANY',
        INTERNAL_ARRANGEMENT: 'INTERNAL_ARRANGEMENT',
    },
    PropertyTypeEnum: {
        APARTMENT: 'アパート',
        CONDOMINIUM: 'マンション',
        DETACHED_HOUSE: '一戸建て',
        OTHER: 'その他',
    },
    RelationshipTypeEnum: {
        SPOUSE: '配偶者',
        RELATIVES: '親族',
        FRIEND: '友人',
        COLLEAGUE: '同僚',
        PARENT: '親',
        CHILD: '子供',
        OTHER: 'その他',
    },
    TenantEmergencyContactEnum: {
        SPOUSE: '配偶者',
        RELATIVES: '親族',
        FRIEND: '友人',
        COLLEAGUE: '同僚',
        PARENT: '親',
        CHILD: '子供',
        OTHER: 'その他',
    },
    TenantPetAvailableEnum: {
        NO: 'なし',
        YES: 'あり',
    },
    RentPaymentTypeEnum: {
        GI_BILL: 'GI Bill',
        UNITED: 'United',
        TENANT_SELF: 'Tenant self',
        CREDIT: 'Credit',
        BANK_TRANSFER: '銀行振込',
        INCLUDED: 'Included',
        OTHER: 'その他',
    },
    TenantUtilityTypeEnum: {
        GI_BILL: 'GI Bill',
        UNITED: 'United',
        TENANT_SELF: 'Tenant self',
        CREDIT: 'Credit',
        BANK_TRANSFER: '銀行振込',
        INCLUDED: 'Included',
        OTHER: 'その他',
    },
    TenantPropertyStatusEnum: {
        UNDER_CONTRACT: 'UNDER_CONTRACT',
        CONTRACT_EXPIRED: 'CONTRACT_EXPIRED',
        MANAGEMENT_ENDED: 'MANAGEMENT_ENDED',
    },
    AccountLockFlagEnum: {
        RELEASE: 'RELEASE',
        LOCK: 'LOCK'
    },
    TenantBranchEnum: {
        AIRFORCE: 'AIRFORCE',
        NAVY: 'NAVY',
        MARINE: 'MARINE',
        ARMY: 'ARMY',
        OTHER: 'OTHER',
    },
    ServiceTenantEnum: {
        ACTIVE_DUTY: 'ACTIVE DUTY',
        CIVILIAN: 'CIVILIAN',
        GS: 'GS',
        RETIRED: 'RETIRED',
        OTHER: 'OTHER',
    },
    JointGuarantorRelationshipEnum: {
        SPOUSE: '配偶者',
        RELATIVES: '親族',
        FRIEND: '友人',
        COLLEAGUE: '同僚',
        PARENT: '親',
        CHILD: '子供',
        OTHER: 'その他',
    },
    ExpenseItemTypeEnum: {
        INCOME: '収入',
        EXPENDITURE: '支出',
    },
    SupplierTypeEnum: {
        MANAGEMENT_COMPANY: '管理会社',
        ELECTRICITY: '電気',
        GAS: 'ガス',
        WATER_SUPPLY: '水道',
        GARBAGE: 'ゴミ',
        OTHER: 'その他',
    },
    PropertySupplierTypeEnum: {
        MANAGEMENT_COMPANY: '管理会社',
        ELECTRICITY: '電気',
        GAS: 'ガス',
        WATER_SUPPLY: '水道',
        GARBAGE: 'ゴミ',
        OTHER: 'その他',
    },
    OwnerContractStatusEnum: {
        UNDER_CONTRACT: '契約中',
        CONTRACT_EXPIRED: '契約終了'
    },
    SepticTankEnum: {
        NO: '無し',
        YES: '有り',
    },
    SupplierFlagEnum: {
        OUR_COMPANY: '自社',
        OTHER_COMPANY: '他社',
    },

    WaterCheckFlagEnum: {
        MUNICIPALITY: '市町村',
        MANAGEMENT_COMPANY_METER_READING: '管理会社検針',
        COMPANY_METER_READING: '自社検針',
    },
    RentGuaranteeTypeEnum: {
        ADD_IF_NECESSARY: '加入要',
        USE_IF_POSSIBLE: '利用可',
    },
    PropertyDrawingsFlagEnum: {
        NONE: '無し',
        AVAILABLE: '有り',
    },
    ParkingDrawingsFlagEnum: {
        NONE: '無し',
        AVAILABLE: '有り',
    },
    NetConnectionStatusEnum: {
        TENANT_ARRANGEMENT: '入居者手配',
        SHARED_INTERNET_AVAILABLE: '共用ネットあり',
    },
    PetStatusEnum: {
        NOT_ALLOWED: 'No Pet',
        LARGE_DOG: 'Dog OK (Large Dog OK)',
        NEGOTIABLE: 'Negotiable',
        ONLY_SMALL_DOG: 'Small Dog Only OK',
        CAT_ALLOWED: 'Cat OK'
    },
    StructureTypeEnum: {
        CB: 'CB（コンクリート・ブロック造）',
        RC: 'RC（鉄筋コンクリート造）',
        RCB: 'RCB（鉄筋コンクリートブロック造）',
        SRC: 'SRC（鉄骨鉄筋コンクリート造）',
        PC: 'PC（プレストレスト・コンクリート造）',
        HPC: 'HPC（鉄筋プレキャストコンクリート造）',
        ALC: 'ALC（軽量気泡コンクリート造）',
        WOOD: '木造',
        S: 'S造（鉄骨構造）',
        OTHER: 'その他',
    },
    InoutNotificationFlagEnum: {
        NONE: '無し',
        AVAILABLE: '有り',
    },
    PropertyTabEnum: {
        PROPERTY_INFORMATION: '物件情報',
        MORE_INFORMATION: '詳細情報',
        ROOM: '部屋',
        OWNER: 'オーナー',
        PAYMENT_LIST: '支払一覧',
        BILLING_LIST: '請求一覧',
        MONTHLY_FEE_SETTING: '月額設定',
        FILE: 'ファイル',
        IMAGES_AND_VIDEOS: '画像・動画',
        OTHER_NOTES: 'その他メモ',
    },
    PropertyRoomMoveInStatusEnum: {
        MOVE_IN: '入居',
        VACANT: '空室',
        AWAITING_MOVE_OUT: '退去待ち',
        MOVED_OUT: '退去済',
        UNDER_MILITARY_INSPECTION: '軍検中',
        MILITARY_INSPECTION_COMPLETE: '軍検済',
        CLEANING_IN_PROGRESS: '清掃中',
        MOVE_IN_PROCEDURE_IN_PROGRESS: '入居手続き中',
        MANAGEMENT_ENDED: '管理終了',
    },
    PropertyRoomTypeEnum: {
        HOUSE: 'House',
        APARTMENT: 'Apartment',
        DUPLEX: 'Duplex',
    },
    PropertyRoomRoomTypeEnum: {
        ROOM: 'ルーム',
        K: 'K',
        DK: 'DK',
        SDK: 'SDK',
        LDK: 'LDK',
        SLDK: 'SLDK',
    },
    PropertyRoomGarbageHowtoTypeEnum: {
        DESIGNATED_GARBAGE_BAG: '指定ゴミ袋',
        CLEAR_BAG: '透明な袋',
        TIE_WITH_STRING: '紐で縛る',
        OTHER: 'その他',
    },
    WeekdayEnum: {
        MONDAY: '月',
        TUESDAY: '火',
        WEDNESDAY: '水',
        THURSDAY: '木',
        FRIDAY: '金',
        SATURDAY: '土',
        SUNDAY: '日',
    },
    PropertyCostTypeEnum: {
        INITIAL: '初期費用',
        MONTHLY: '月額費用',
    },
    PropertyBpTypeEnum: {
        INCOME: '収入',
        EXPENDITURE: '支出',
    },
    PropertyTenantCostBpTypeEnum: {
        INCOME: '収入',
        EXPENDITURE: '支出',
    },
    PropertyTenantCostTypeEnum: {
        INITIAL: '初期費用',
        MONTHLY: '月額費用',
    },
    PropertyOwnerCostBpTypeEnum: {
        INCOME: '収入',
        EXPENDITURE: '支出',
    },
    PropertyOwnerCostTypeEnum: {
        INITIAL: '初期費用',
        MONTHLY: '月額費用',
    },
    PaymentInvoiceKindEnum: {
        BILLING: '請求',
        PAYMENT: '支払',
    },
    PaymentInvoiceTypeEnum: {
        INITIAL: '初期費用',
        MONTHLY: '月額費用',
        MOVING_OUT: '退去費用',
        OTHER: 'その他',
    },
    PaymentInvoicePaymentTypeEnum: {
        FULL: '全額',
        PARTIAL: '一部',
    },
    PaymentInvoiceDetailBpTypeEnum: {
        INCOME: '収入',
        EXPENDITURE: '支出',
    },
    PropertyPaymentInvoiceDetailBpTypeEnum: {
        INCOME: '収入',
        EXPENDITURE: '支出',
    },
    PropertyRoomParkingTypeEnum: {
        ARRANGED_MANAGEMENT_COMPANY: '管理会社手配',
        ARRANGED_COMPANY: '自社手配',
    },
    PropertyRoomParkingCertificateTypeEnum: {
        ARRANGED_MANAGEMENT_COMPANY: '管理会社手配',
        ARRANGED_COMPANY: '自社手配',
    },
    PropertyRoomParkingSpaceEnum: {
        NONE: 'なし',
        ON_SITE: '敷地内',
        NEARBY_AVAILABLE: '付近あり',
    },
    RoomTypeEnum: {
        ROOM: 'ルーム',
        KITCHEN: 'K（キッチン）',
        DK: 'DK（ダイニングキッチン）',
        SDK: 'SDK（サービスルーム・ダイニングキッチン）',
        LDK: 'LDK（リビングダイニングキッチン）',
        SLDK: 'SLDK（サービスルーム・リビングダイニングキッチン）',
    },
    PostTypeEnum: {
        NONE: 'なし',
        DIAL: 'ダイヤル',
        KEY: '鍵',
    },
    PropertyRoomOwnerContractStatusEnum: {
        UNDER_CONTRACT: '契約中',
        CONTRACT_EXPIRED: '契約終了'
    },

    MaintenanceStatusEnum: {
        NOT_PROCESSED: '未対応',
        IN_PROCESSING: '対応中',
        PROCESSED: '対応済'
    },

    MaintenanceCostKind: {
        BILLING: '請求',
        PAYMENT: '支払',
    },

    RoomTypeCode: {
        ROOM: 'ルーム',
        KITCHEN: 'K',
        DK: 'DK',
        SDK: 'SDK',
        LDK: 'LDK',
        SLDK: 'SLDK',
    },
    YellowcardPetEnum: {
        NO: 'NO',
        YES: 'YES',
        NEGOTIABLE: 'NEGOTIABLE',
    },
    TransactionTypeEnum: {
        PURCHASE: 'PURCHASE',
        RENT: 'RENT',
    },
    OwnerAgentEnum: {
        OWNER: 'OWNER',
        AGENCY: 'AGENCY',
    },
    KitchenStoveTypeEnum: {
        GAS: 'GAS',
        ELECTRIC: 'ELECTRIC',
    },
    DecisionTypeEnum: {
        NO: 'NO',
        YES: 'YES',
    },
    CheckStatusEnum: {
        NO_CHECK: 'no check',
        CHECK: 'check',
    },
    MilitaryInspectionApplicationTypeEnum: {
        NEW: '新規検査',
        RENEWAL: '更新検査',
        RE_INSPECTION: '再検査',
    },
    ApplicationTypeEnum: {
        COMPANY: '自社',
        OWNER: 'オーナー',
    },
    MilitaryDecisionTypeEnum: {
        NO: 'なし',
        YES: 'あり',
    },
    maintenance_cost_search: {
        owner: 'オーナー',
        tenant: '入居者',
        supplier: '取引先'
    },
    PropertyImageTypeEnum: {
        IMAGE: '画像',
        VIDEO: '動画',
    },
    TenantNationalityEnum: {
        AMERICA_KA: '米Ka',
        AMERICA_CI: '米Ci',
        JAPAN: '日',
    },
    TenantResidenceStatusEnum: {
        BEFORE_MOVING_IN: '入居前',
        CURRENTLY_MOVING_IN: '入居中',
        REMOTE: '退去済',
    },
    RoomImageTypeEnum: {
        IMAGE: '画像',
        VIDEO: '動画',
    },
    ExpenseItemTaxRateEnum: {
        RATE_10_PERCENT: '10%',
        RATE_8_PERCENT_REDUCED: '8%（軽減税率）',
        RATE_8_PERCENT: '8%',
        RATE_0_PERCENT: '0%',
    },
    InvoiceAddFlagEnum: {
        NOT_REFLECTED: '未反映',
        REFLECTED: '反映済',
    },
    EndedReasonTypeEnum: {
        TRANSFER_ANOTHER_COMPANY: '他社管理移行',
        RETURN_TO_OWNER: 'オーナー返却',
        CHANGE_OF_OWNER: 'オーナー変更',
        PLAN_FOR_SALE: '売買予定',
        OTHER: 'その他',
    },
    InspectionEnum: {
        NO: 'NO',
        YES: 'YES',
    },
    PropertyRoomFurnishedEnum: {
        NO: 'NO',
        YES: 'YES',
    },
    FixtureEnum: {
        BATH_AND_TOILET: 'Bath and toilet separated',
        BATH_TUB: 'Bath tub',
        INTERNET: 'Internet',
        ELEVATOR: 'Elevator',
        STORAGE: 'Storage',
        SECURITY: 'Security system',
    },
    EnvironmentEnum: {
        YARD: 'Yard',
        PATIO: 'Patio',
        BALCONY: 'Balcony',
        BBQ_OK: 'BBQ OK',
        PET_FRIENDLY: 'Pet Friendly',
        FAMILY_FRIENDLY: 'Family Friendly',
    },
    LocationEnum: {
        OCEAN_VIEW: 'Ocean View',
        CLOSE_TO_PARK: 'Close to Park',
        CLOSE_TO_BEACH: 'Close to Beach',
        SUPERMARKET: 'Super Market',
        CONVERIENCE_STORE: 'Converience Store',
        QUIET_AREA: 'Quiet Area',
    },
    ParkingSpaceTypeEnum: {
        ROOF: 'Roof',
        GARAGE: 'Garage',
        ENCLOSED: 'Enclosed',
        MECHANICAL: 'Mechanical',
    },
    ParkingSpaceLineEnum: {
        VERTICAL: '縦列',
        PARALLEL: '並列',
        MECHANICAL: '機械式',
    },


    // breadcrumbs
    breadcrumbs: {
        account: {
            index: 'アカウント',
            list: 'アカウント一覧',
        },
        owner: {
            index: 'オーナー管理',
            list: 'オーナー一覧',
            detail: 'オーナー詳細'
        },
        expense_item: {
            index: '費用項目',
            list: '費用項目一覧',
        },
        areas: {
            index: '物件エリア',
            list: '物件エリア一覧',
        },
        supplier: {
            index: '取引先',
            list: '取引先一覧',
        },
        tenant: {
            index: '入居者管理',
            list: '入居者一覧',
            detail: '入居者詳細'
        },
        property: {
            index: '物件管理',
            list: '物件一覧',
            detail: '物件詳細'
        },
        setting: {
            index: '設定',
            list: '設定一覧',
        },
        holiday: {
            index: '休業日',
            list: '休業日一覧',
        },
        blog_article: {
            index: 'ブログ記事',
            list: 'ブログ記事一覧',
        },
    },
    ApiClientStatusEnum: {
        DISABLED: '無効',
        ENABLED: '有効',
    },
    BillInvoiceAddFlagEnum: {
        NOT_REFLECTED: '未反映',
        REFLECTED: '反映済',
    },

    confirm_update_hp_room: {
        button_publish: '公開する',
        button_no_publish: '非公開する',
        text_msg_publish: 'HPに公開にします。よろしいですか?',
        text_msg_no_publish: 'HPから非公開にします。よろしいですか？',
    },

    // screens
    screens: {
        dashboard: {
            manage_property: '管理物件（部屋）',
            tenants: '入居者',
            payment_past_due_date: '入金期日超過',
            overdue_payment: '支払期日超過',
            vacant_property: '空室',
            list: '一覧',
            maintenance_property_title: 'メンテナンス対応中物件',
            tenant_property_title: '定借満了6ヵ月前',
            date_expired: '定借満了',
            property_title: '20年検査期限3ヵ月前',
            deadline: '期限',
            waiting_move_out: '退去待ち',
            under_military_inspection: '軍検中',
            cleaning: '清掃中',
            occupancy_rate: '入居率',
            tenant_list: '入居一覧',
            vacancy_list: '空室一覧',
            paid: '入金済',
            unpaid: '未入金',
            payment_rate: '入金率',
            payment_rate_for_month: '当月入金率',
            payment_rate_for_year: '当年入金率',
            paid_list: '入金済一覧',
            unpaid_list: '未入金一覧',

        },
        account: {
            index: {
                page_title: 'アカウント一覧',
                search: {
                    title: 'アカウント検索',
                    name: 'アカウント名（部分一致）',
                },
                register: 'アカウント登録',
                edit: 'アカウント編集',
                locked: 'ロック中',
            },
        },
        blog_article: {
            index: {
                page_title: 'ブログ記事一覧',
                search: {
                    title: 'ブログ記事検索',
                },
                register: 'ブログ記事登録',
                edit: 'ブログ記事編集',
            },
        },
        login_twofactor: {
            title: 'メールアドレスに送信された認証コードを入力して下さい。',
            btn_resend_code: '認証コードを再送信する',
            btn_back_to_login: 'ログインへ戻る',
            modal: {
                title: '認証コードの再送信',
                msg: '認証コードを再送信します。よろしいですか？'
            }
        },
        owner: {
            index: {
                page_title: 'オーナー一覧',
                search: {
                    title: 'オーナー検索',
                    owner_name: 'オーナー名（部分一致）',
                    owner_id: {
                        title: 'オーナーID（部分一致）※「L-」以降を入力。',
                        placeholder: '「L-」以降を入力'
                    },
                    property_name: '物件名（部分一致）',
                    owner_address: {
                        title: '住所（部分一致）※市区町村を入力。',
                        placeholder: '市区町村を入力'
                    }
                }
            },
            detail: {
                page_title: 'オーナー詳細',
                name: '様',
                tab_list: {
                    owner_info: 'オーナー情報',
                    owner_properties: '保有物件',
                    other_notes: 'その他メモ'
                },
                owner_properties: {
                    contract_period: '契約期間'
                },
                delete_owner_button: 'オーナー削除'
            },
            create: {
                title: 'オーナー登録',
                post_code: '〒',
                post_code_title: '郵便番号（ハイフンあり)',
                tel_title: 'TEL（ハイフンあり）',
                pref_id_title: '住所1（都道府県）',
                address_title: '住所2（市区町村以降）',
            },
            edit: {
                title: 'オーナー情報',
                edit_memo_title: 'その他メモ',
                post_code_title: '郵便番号（ハイフンあり）',
                tel_title: 'TEL（ハイフンあり）',
            }
        },
        expense_item: {
            index: {
                page_title: '費用項目一覧',
                search: {
                    title: '費用項目検索',
                    name: '費用項目名（部分一致）',
                },
                register: '費用項目登録',
                edit: '費用項目編集',
            },
        },
        areas: {
            index: {
                page_title: '物件エリア一覧',
                search: {
                    title: '物件エリア検索',
                    name: '物件エリア名（部分一致）',
                },
                register: '物件エリア登録',
                edit: '物件エリア編集',
            },
        },
        supplier: {
            index: {
                page_title: '取引先一覧',
                search: {
                    title: '取引先検索',
                    customer_name: '取引先名（部分一致）',
                },
                register: '取引先登録',
                edit: '取引先編集',
            },
            create: {
                post_code: '郵便番号',
                code: '〒',
            },
        },
        setting: {
            index: {
                setting_project: '設定項目',
                setting_value: '設定値',
                company_name: '会社名',
                address: '住所',
                tel: 'TEL',
                stamp_url: '社印画像',
                email_address: 'メールアドレス',
                account_info1: '口座情報①',
                account_info2: '口座情報②',
                invoice_regis_number: 'インボイス登録番号',
                tenant_billing_due_date: '入居者請求デフォルト期日',
                tenant_payment_due_date: '入居者支払デフォルト期日',
                owner_billing_due_date: 'オーナー請求デフォルト期日',
                owner_payment_due_date: 'オーナー支払デフォルト期日',
                establish: '創業年',
                president_name: '代表者',
                business_hour: '営業時間',
                service: '事業内容',
                license: '認可・免許',
                lang_support: '対応言語',
                site_url: 'WebサイトURL',
                image_url: '会社画像',
            },
            update: {
                pl_company_name: '物件エリア名',
                pl_invoice_number: '口座番号',
            }
        },
        holiday: {
            index: {
                page_title: '休業日一覧',
                close_date: '休業日',
                holiday_name: '休業日名',
                edit: '編集',
                delete: '削除',
                register: '休業日登録',
                year: '年',
            },
            placeholder: {
                holiday_name: '休業日名',
            },
            edit: '編集'
        },
        tenant: {
            index: {
                page_title: '入居者一覧',
                search: {
                    title: '入居者検索',
                    name: '入居者名（部分一致）',
                    view_id: '入居者ID（部分一致）※「T-」以降を入力。',
                    property_name: '物件名（部分一致）',
                    ph_view_id: '「T-」以降を入力',
                    ph_property_name: '物件名',
                    movein_date: '入居年月',
                    before_moving_in: '入居前',
                    currently_moving_in: '入居中',
                    remote: '退去済',
                    residence_status: '入居ステータス',
                    rent_payment_type: '家賃支払方法',
                },
                register: '入居者登録',
//                edit: ' 詳細',
            },
            detail: {
                page_title: '入居者詳細',
                title_name: '入居者名',
                title_name_kana: '入居者名カナ',
                tab_list: {
                    tenant_info: '入居者情報',
                    tenant_properties: '入居物件',
                    tenant_service: 'その他メモ'
                },
                view_id: 'ID',
                cust_id: 'Cust ID',
                name: '入居者名',
                rank: 'ランク',
                branch: 'BRANCH',
                service: 'SERVICE',
                base: {
                    name: '勤務地'
                },
                building: 'WORKING BASE BUILDING #',
                organization: 'ORGANIZATION',
                commander_name: 'COMMAND’S NAME',
                commander_tel: 'COMMAND’S TEL',
                supervisor_name: 'SUPERVISOR’S NAME',
                supervisor_tel: 'SUPERVISOR’S TEL',
                rent_payment_type: '家賃支払い',
                zip: '郵便番号',
                pref: {
                    name: '住所1（都道府県）'
                },
                address: '住所2（市区町村以降）',
                tel: 'TEL',
                at_work_tel: '勤務中TEL',
                email: 'メールアドレス',
                email_secondary: 'メールアドレス（予備）',
                military_address: 'MILITARY ADDRESS(APO)',
                social_security_number: 'SOCIAL SECURITY NUMBER',
                car_number: '車両ナンバー',
                date_of_birth: '生年月日',
                housemate_memo: '同居人備考',
                emergency_contact_memo: '緊急連絡先備考',
                pet_info: 'ペット備考',
                pet_available: 'ペット',
                pet_large_dog_count: 'Large Dog',
                pet_small_dog_count: 'Small Dog',
                pet_cat_count: 'Cat',
                pet_other_count: 'Other',
                bank_name: '銀行名',
                bank_branch_name: '支店名',
                bank_account_number: '口座番号',
                bank_account_type: '口座種別',
                bank_account_name: '口座名義',
                memo: 'メモ',
                delete_tenant_button: '入居者削除'
            },
            edit: {
                title: '入居者情報',
                edit_memo_title: 'その他メモ'
            },
            tenants_properties: {
                view_id: 'ID',
                name: '物件名',
                room_number: '部屋No',
                status: {
                    1: '契約中',
                    9: '契約終了',
                    2: '管理終了',
                },
                contract_date: '契約期間',
                tenant_memo: '入居者メモ',
                yearly: '年間',
            },
            joint_guarantor: {
                title: '連帯保証人または共同契約者',
                name: '名前',
                name_kana: 'カナ',
                type: '	関係性',
                tel: 'TEL',
                email: 'メールアドレス',
                ssn: 'SSN',
            },
            housemate: {
                title: '同居人',
                name: '名前',
                name_kana: '同居人名カナ',
                type: '	関係性',
                tel: 'TEL',
                email: 'メールアドレス',
                age: '年齢',
            },
            emergency: {
                title: '緊急連絡先',
                name: '名前',
                name_kana: 'カナ',
                type: '	関係性',
                zip: '住所',
                tel: 'TEL',
                email: 'メールアドレス',
            },
        },
        property: {
            index: {
                page_title: '物件一覧',
                search: {
                    title: '物件検索',
                    object_name: '物件名（部分一致）',
                    id: 'ID（前方一致）',
                    tenant_cost_amount: '価格',
                    pet_status: 'ペット',
                    area_name: 'エリア',
                    movein_status: 'ステータス',
                    ended_reason_type: '契約終了理由',
                    number_of_bed: 'ベッド数',
                    number_of_toilet: 'トイレ数',
                    type: 'タイプ',
                    room_count: '間取り',
                    placeholder: {
                        object_name: '物件名',
                        id: 'ID',
                    },
                    floor_plan: '間取り',
                },
                register: '物件登録',
                area_name: 'エリア',
                room_count: '間取り',
                pet_status: 'ペット',
                tenant_cost_amount: '家賃',
                movein_status: 'ステータス',
                floor_plan: '間取り',
            },
            create: {
                management_company: '管理会社名',
                supplier: '事業者名',
                city: '市町村名',
                add: '追加',
                option: '選択',
            },
            detail: {
                page_title: '物件詳細',
                title: 'ALPHA STATES CHATAN HILLS',
                delete_button: '物件削除',
                delete_room: '部屋削除',
                tenant_property: {
                    title_edit: '編集',
                    tenant: '入居者',
                    change_text: '変更する',
                    title_create: '登録',
                    register: '入居者登録',
                    btn_mark_move_out: '退去済みにする',
                    msg_mark_move_out: '退去済みにします。よろしいですか？',
                    move_out: {
                        title: '退去処理',
                        sub_title: '退去処理を実行します。よろしいですか？',
                        plan_moveout_date: '退去予定日',
                        moveout_date: '退去日',
                        accrual_date: '最終精算日',
                        period_date: '入金期日',
                        msg_confirm: '退去待ちにします。よろしいですか？',
                        fly_out_date: 'Fly Out日',
                    },
                    btn_to_move_in: '入居にする',
                    btn_mark_move_in: '入居中にする',
                    msg_mark_move_in: '入居中に戻します。よろしいですか？',
                },
                property_information: {
                    zip: '郵便番号',
                    address: '住所',
                    water_channel_photothermal: '水道光熱',
                    businesses_municipalities: '事業者・市町村',
                    management_company_name: '管理会社名',
                    email_address: 'メールアドレス',
                },
                room: {
                    name_tab: {
                        room_information: '部屋情報',
                    },
                    room_information: {
                        type: 'タイプ',
                        number_of_bed: 'ベッド数',
                        number_of_toilet: 'トイレ数',
                        room_size: '部屋サイズ',
                        room: '部屋',
                        size: 'サイズ',
                        entrance_door_master: '玄関ドア（マスター）',
                        entrance_door_copy: '玄関ドア（コピー）',
                        parking: '駐車場',
                        garbage_dump: 'ゴミ捨て場',
                        rubbish: 'ゴミ',
                        how_to_serve: '出し方',
                        floor_plan: '間取り',
                        floor_plan_note: '間取り備考',
                        exclusive_area: '専有面積',
                        mailbox: '郵便受け',
                        mailbox_note: '郵便受け備考',
                        key: 'カギ',
                        place: '場所',
                        master_key: '入居者',
                        office: '事務所',
                        total: '合計',
                        main: '建物エントランス（マスター）',
                        back_door: 'バックドア',
                        other: 'その他',
                        owner_history: 'オーナー履歴',
                        contract: '契約',
                        end: '契約終了にする',
                        owner_change: 'オーナー変更',
                        confirm_end_contract: '契約を終了します。よろしいですか？',
                        tenants: '入居者',
                        book: '本',
                        main_copy: '建物エントランス（コピー）',
                        key_number: '鍵番号',
                        master: 'マスター',
                        copy: 'コピー',
                        back: 'バック',
                        ended_reason_type: '契約終了理由',
                        owner_change_modal: {
                            title: 'オーナー変更',
                            owner: 'オーナー',
                        },
                        edit: {
                            title: '設備',
                            dial_number: 'ダイヤル番号',
                            owner_contract_date: '契約日',
                            building_entrance_master: '建物エントランス（マスター）',
                            building_entrance_copy: '建物エントランス（コピー）',
                            entrance_door_master: '玄関ドア（マスター）',
                            entrance_door_copy: '玄関ドア（コピー）',

                        },
                        tenant_information_sheet: '入居情報シート',
                        parking_type: '駐車場手配',
                        parking_space: '場所',
                        number_of_parking: '駐車台数',
                        parking_space_type: '駐車場タイプ',
                        parking_space_line: '並び',
                        parking_number: '駐車場番号',
                        parking_certificate_type: '車庫証明の取得',
                        parking_certificate_comment: '駐車場備考',
                        inspection: 'INSPECTION',
                        fixtures: '設備・特徴',
                        appliances: '家電設備',
                        high_school: '高校',
                        middle_school: '中学校',
                        elementary_school: '小学校',
                        environment: '環境',
                        location: 'ロケーション',
                        hp_title: 'HP用タイトル',
                        number_of_floors: '階数',
                        bath_room_count: 'BATH ROOMS',
                        furnished: '家具付き',
                        available_date: '利用可能日',
                    },
                    yellow_card: {
                        title: 'YellowCard',
                        story_storage: 'STORY & STORAGE',
                        security_deposit: 'REGISTERED RENT NOT TO EXCEED & SECURITY DEPOSIT',
                        deposit: 'DEPOSIT',
                        other: 'OTHER',
                        phone_email: 'PHONE & EMAIL ADDRESS',
                        room: 'ROOM',
                        photo_check: 'I HAVE SUBMITTED A MINIMUM OF 5 PHOTOS,BUT NO MORE THAN 10 FOR THIS LISTING',
                        unit_built_mmddyy: 'UNIT BUILT DATE',
                        rent: 'RENT',
                        emergency: 'EMERGENCY',
                        email: 'EMAIL',
                        date: 'DATE',
                        water_label: 'WATER',
                        net_sqft: 'SQFT',
                        pets: {
                            type: 'TYPE',
                            pets_max_weight: 'WEIGHT',
                            pets_type_not_allowed: 'TYPE NOT ALLOWED',
                        },
                        dist_from: {
                            miles: 'MILES',
                            time: 'TIME',
                        },
                        bath: {
                            title: 'BATH',
                            bath_comment: 'Full comment',
                            option: {
                                bath_full: 'FULL',
                                bath_12: '1/2',
                                bath_jacuzzi: 'JACUZZI',
                                bath_washlet: 'WASHLET',
                            },
                        },
                        kitchen: {
                            title: 'KITCHEN',
                            stove: 'STOVE',
                            stove_type: 'STOVE TYPE',
                            option_1: {
                                kitchen_connection_for_stove: 'CONNECTION FOR STOVE',
                                kitchen_refrig: 'REFRIG',
                                kitchen_connection_for_refrig: 'CONNECTION FOR REFRIG',
                            },
                            option_2: {
                                kitchen_oven: 'OVEN',
                                kitchen_microwave: 'MICROWAVE',
                                kitchen_dishwasher: 'DISHWASHER',
                                kitchen_disposal: 'DISPOSAL',
                            },
                        },
                        dod_school_district: {
                            title: 'DOD SCHOOL DISTRICT',
                            highschool: 'HIGHSCHOOL',
                            middle: 'MIDDLE',
                            elementary: 'ELEMENTARY',
                        },
                        washer_dryer: {
                            title: 'WASHER & DRYER',
                            option_1: {
                                washer: 'WASHER',
                                connection_for_washer: 'CONNECTION FOR WASHER',
                                connection_for_dryer: 'CONNECTION FOR DRYER',
                            },
                            option_2: {
                                gas_dryer: 'GAS DRYER',
                                electric_dryer: 'ELECTRIC DRYER',
                            },
                        },
                        garage_parking: {
                            title: 'GARAGE & PARKING',
                            option: {
                                garage: 'GARAGE',
                                parking_space: 'PARKING SPACE',
                                other: 'OTHER',
                            },
                        },
                        water: {
                            title: 'WATER HEATER',
                            option: {
                                water_heater_kerosene: 'KEROSENE',
                                water_heater_gas: 'GAS',
                                water_heater_electric: 'ELECTRIC',
                                water_heater_all_electric: 'ALL ELECTRIC',
                            },
                        },
                        air_cond_heater: {
                            title: 'AIR COND/HEATER',
                            option: {
                                air_cond_heater_central: 'CENTRAL',
                                air_cond_heater_window: 'WINDOW',
                                air_cond_heater_wall_mounted: 'WALL MOUNTED',
                            },
                        },
                        utilities_paid_by: {
                            title: 'UTILITIES PAID BY',
                            option: {
                                utilities_paid_by_landlord: 'LANDLOAD',
                                utilities_paid_by_tenant: 'TENANT',
                            },
                        },
                        community_information: {
                            title: 'COMMUNITY INFORMATION',
                            option_1: {
                                community_information_fitness: 'FITNESS CENTER',
                                community_information_clubhouse: 'CLUB HOUSE',
                                community_information_waterfront: 'WATERFRONT',
                            },
                            option_2: {
                                community_information_playground: 'PLAY GROUND',
                                community_information_waterview: 'WATER VIEW',
                                community_information_community_courts: 'COMMUNITY COURTS',
                            },
                        },
                        features: {
                            title: 'FRATURES',
                            option_1: {
                                features_utility_shed: 'UTILITY SHED',
                                features_outside_storage: 'OUTSIDE STORAGE',
                                features_office_extraroom: 'OFFICE/EXTRA ROOM',
                            },
                            option_2: {
                                features_patio: 'PATIO',
                                features_fenced_yard: 'FENCED YARD',
                                features_balcony: 'BALCONY',
                            },
                            option_3: {
                                features_garage_door_opener: 'GARAGE DOOR OPENER',
                                features_pool: 'POOL',
                                features_internet_ready: 'INTERNET READY',
                            },
                            option_4: {
                                features_window_coverings: 'WINDOW COVERINGS',
                                features_skylights: 'SKYLIGHTS',
                            },
                        },
                        safety_security: {
                            title: 'SAFETY & SECURITY',
                            option_1: {
                                safety_alarm_system: 'ALARM SYSTEM',
                                safety_gate_access: 'GATE ACCESS',
                            },
                            option_2: {
                                safety_door_bell: 'SECURITY DOOR BELL',
                                safety_smoke_detector: 'SMOKE DETECTOR',
                            },
                        },
                        signature: {
                            type_of_date: 'DATE（MM/DD/YY）',
                        },
                    },
                    military_inspection_applications: {
                        examination_date: '検査日',
                        form: {
                            title: '軍検申請書',
                            property_address: '物件住所',
                            preferred_date: '軍検査希望日',
                            first_time: '初回',
                            retest: '再検査',
                            enter_and_exit: '出入りの方法',
                            key_box_code: '鍵ボックスのコード',
                            pin_number: '暗唱番号',
                            zenrin_map: 'ゼンリン地図（物件・駐車場配置図）',
                            certificate: '登記簿謄本（全部事項証明書）',
                            compliance_certificate: '鉛塗料/アスベスト/消防法適合証明書',
                            building_inspection: '建物診断報告書/平面図/建築士免許',
                            notice_eviction: '退去/明け渡し通告書',
                            documents_proving_repairs: '修繕したことを証明する書類',
                            image: '掲示する為の写真5－10枚',
                        }
                    },
                    update_movein_status: {
                        title: 'ステータス変更',
                        msg_confirm: 'ステータスを変更します。よろしいですか？',
                    }
                },
            },
            edit: {
                title: '詳細情報',
                year: '年',
                ping: '坪',
                pet_detail: 'ペット条件',
                floor: '階建',
            },
        },
        property_room: {
            create: {
                title: '部屋登録',
                room_no: '号室',
                tenant: '入居者',
                owner: 'オーナー',
                owner_name: 'オーナー名',
                option: '選択',
            },
        },
        income: {
            create: {
                title: '項目追加'
            },
            edit: {
                title: '項目編集',
            },
            room_no: '部屋No',
            project: '項目',
            amount: '金額',
            remarks: '備考',
            JPY: '円',
            no_expenditure_item: '支出項目はありません。',
            no_income_item: '収入項目はありません。',
            total_income: '収入合計',
            total_expenditure: '支出合計',
            income_expenditure: '収入 - 支出',
            consumption_tax: '消費税',
        },

        room_billing_list_tab: {
            btn_create_billing: '請求明細登録',
            index: {
                btn_search: '検索',
            },
            detail: {
                paid_title: '入金済',
                unpaid_title: '未入金',
                due_date: '期日',
                btn_csv_download: '請求明細',
                btn_invoice_pdf_download: '領収書',
                status_change: 'ステータス変更',
            },
            edit: {
                title: '編集',
            }
        },

        room_payment_list_tab: {
            btn_create_payment: '支払明細登録',
            detail: {
                paid_title: '支払済',
                unpaid_title: '未払い',
                btn_csv_download: '支払明細',
            },
        },
        utilities: {
            create: {
                title: '登録',
            },
            edit: {
                title: '編集',
                supplier: '事業者',
            },
            detail: {
                supplier: '事業者',
                contact: '連絡先',
                billing_address: '請求先',
            },
            index: {
                search: '検索',
                supplier_id1: 'その他請求先1',
                supplier_id2: 'その他請求先2',
                supplier_id3: 'その他請求先3',
                supplier_id4: 'その他請求先4',
                supplier_id5: 'その他請求先5',
                link_detail_payment: '請求明細反映済み',
                txt_detail_payment: '請求明細に反映',
            },
            amount: '金額',
            JPY: '円',
            tab: {
                electric: '電気',
                gas: 'ガス',
                water: '水道',
                trash: 'ゴミ',
            },
            txt_request_detail: '請求明細',
            btn_reflect: '反映する',
        },
        property_room_utility_cost: {
            can_be: 'あり',
            none: 'なし',
            tenant: '入居者',
            owner: 'オーナー',
            meter: 'メーター',
            m3: '㎥',
            amount: '金額',
        },
        property_room_owner: {
            search: '検索',
            placeholder_search: '部屋Noまたはオーナー名',
            owner_information: {
                title: 'オーナー情報',
                room_no: '部屋No'
            },
            payment_list: {
                title: '支払一覧'
            },
            billing_list: {
                title: '請求一覧'
            },
            payment_setting: {
                title: '家賃設定'
            },
            other_note: {
                title: 'その他メモ',
                placeholder_text: 'その他メモ'
            },
        },

        room_rent_setting_tab: {
            monthly_tab: '月額',
            initial_tab: '初期',
            monthly_detail: {
                set_up_title: '毎月定期的に発生する定額費用を設定してください。'
            },
            initial_detail: {
                set_up_title: '初期費用を設定してください。'
            }
        },
        room_maintenance_tab: {
            maintenance_create_update: {
                title_create: '登録',
                title_update: '編集'
            },
            maintenance_cost_create_update: {
                title_create: '登録',
                search_name_owner: 'オーナー名',
                search_name_tenant: '入居者名',
                search_name_supplier: '取引先名',
                option: '選択',
                title_edit: '詳細',
                billing_address: '請求先',
                payment_destination: '支払先',
                property_name: '物件名',
                btn_billing_csv_download: '請求明細',
                btn_payment_csv_download: '支払明細',
                status_change: 'ステータス変更',
            },
            maintenance_history_create_update: {
                title: '履歴'
            },
            detail: {
                billing_address: '請求先',
                payment_destination: '支払先',
                charge: '請求額',
                payment_amount: '支払額',
                edit_title: '編集',
                del_title: '削除',
                btn_create_billing: '請求明細登録',
                btn_create_payment: '支払明細登録',
                datetime_title: '日時',
                image_title: '画像',
                comment_title: 'コメント',
                btn_create_history: '履歴登録'
            }
        },
        other_note_tab: {
            edit: {
                title: 'その他メモ',
            }
        },
        file_tab: {
            index: {
                datetime_upload: 'アップロード日時',
                file_name: 'ファイル名',
            },
            upload: {
                file: 'ファイル',
                file_select: 'ファイル選択',
            }
        },
        image_and_video_tab: {
            title: '画像・動画',
            index: {
            },
            upload: {
                image: '画像',
                type: '種類',
                select_image: '画像選択',
                youtube_id: 'YouTube ID',
                title: 'タイトル'
            }
        },
        owner_payment_billing_tab: {
            btn_create_billing: '請求明細登録',
            btn_create_payment: '支払明細登録',
            index: {
                btn_search: '検索',
            },
            detail: {
                paid_title_payment: '支払済',
                paid_title_billing: '入金済',
                unpaid_title_payment: '未払い',
                unpaid_title_billing: '未入金',
                due_date: '期日',
                payment_detail_download: '支払明細',
                request_detail_download: '請求明細',
                status_change: 'ステータス変更',
                amount: '金額',
            },
            edit: {
                title: '編集',
            }
        },

        property_payment_billing_tab: {
            btn_create_billing: '請求明細登録',
            btn_create_payment: '支払明細登録',
            create: {
                supplier_name: '取引先名',
                option: '選択',
            },
            index: {
                supplier_name: '取引先',
                btn_search: '検索',
            },
            detail: {
                paid_title_payment: '支払済',
                paid_title_billing: '入金済',
                unpaid_title_payment: '未払い',
                unpaid_title_billing: '未入金',
                due_date: '期日',
                payment_detail_download: '支払明細',
                request_detail_download: '請求明細',
                status_change: 'ステータス変更',
                amount: '金額',
            },
            edit: {
                title: '編集',
            }
        },

        monthly_setting_tab: {
            client: '取引先',
            search: '検索',
            amount: '金額',
            date_flag: '発生日',
            supplier_name: '取引先名',
            index: {
                btn_payment_setting: '支払設定',
                btn_invoice_setting: '請求設定',
            },
            create: {
            },
            payment: {
                title_modal: '支払設定',
                title: '毎月定期的に発生する支払明細を設定してください。',
                btn_create: '支払設定登録',
                limit_flag: '支払期日',
            },
            invoice: {
                title_modal: '請求設定',
                title: '毎月定期的に発生する請求明細を設定してください。',
                btn_create: '請求設定登録',
                limit_flag: '入金期日',
            },
        },

        invoice: {
            title: '請求一覧',
            breadcrumbs: {
                billing_management: '請求管理',
                billing_list: '請求一覧'
            },
            search: {
                title: '請求明細検索',
                describe: '（部分一致）',
            },
            property_name: '物件名',
            owner_name: 'オーナー名',
            tenant_name: '入居者名',
            period_date: '入金期日',
            deposit_status: '入金ステータス',
            billing_address: '請求先',
            amount: '金額',
            status: 'ステータス',
            csv_download: '取引明細CSVダウンロード',
            csv_upload: '入金消込CSVアップロード',
            gi_csv_upload: 'GI入金消込CSVアップロード',
            unpaid_title: '未入金',
            paid_title: '入金済',
            csv_sample_download: '消込CSVフォーマットのダウンロード',
            gi_csv_sample_download: 'GI消込CSVフォーマットのダウンロード',
            import_csv: {
                title: '入金消込',
                title_detail: '未入金明細',
                option: '選択',
                due_date: '入金期日',
                request_amount: '請求額',
                billing_address: '請求先',
                paid: '入金済',
                total: '合計',
                deposit_date: '入金日',
                confirm_full_payment: '登録します。よろしいですか？',
                confirm_partial_payment: '金額が一致しません。一部入金にします。よろしいですか?',
                confirm_gi_partial_payment: '行目の入金データが一致しません。一部入金にします。よろしいですか？',
                confirm_over_payment: '入金額が請求明細の合計額を超過しています。',
                row: '行目',
                upload_modal: {
                    file: 'ファイル',
                    file_select: 'ファイル選択',
                },
            },
            detail: {
                title_create: '詳細',
                billing_address: '請求先',
                property_name: '物件名',
                accrual_date: '発生日',
                due_date: '入金期日',
                deposit_date: '入金日',
                btn_billing_csv_download: '請求明細',
                btn_payment_csv_download: '支払明細',
                status_change: 'ステータス変更',
                payment_date: '入金日',
                btn_invoice_pdf_download: '領収書',
            }
        },

        payment: {
            title: '支払一覧',
            breadcrumbs: {
                payment_management: '支払管理',
                payment_list: '支払一覧'
            },
            search: {
                title: '支払明細検索',
                describe: '（部分一致）',
            },
            property_name: '物件名',
            owner_name: 'オーナー名',
            tenant_name: '入居者名',
            period_date: '支払期日',
            deposit_status: '支払ステータス',
            billing_address: '支払先',
            amount: '金額',
            status: 'ステータス',
            csv_download: '取引明細CSVダウンロード',
            csv_upload: '支払消込CSVアップロード',
            unpaid_title: '未払い',
            paid_title: '支払済',
            journal_download_csv: '仕訳帳CSVダウンロード',
            import_csv: {
                title: '支払消込',
                title_detail: '未入金明細',
                option: '選択',
                due_date: '支払期日',
                request_amount: '支払額',
                billing_address: '支払先',
                paid: '支払済',
                total: '合計',
                deposit_date: '支払日',
                upload_modal: {
                    file: 'ファイル',
                    file_select: 'ファイル選択',
                },
                confirm_full_payment: '登録します。よろしいですか？',
                confirm_partial_payment: '金額が一致しません。一部支払にします。よろしいですか?',
                confirm_over_payment: '支払額が支払明細の合計額を超過しています。',
            },
            detail: {
                title_create: '詳細',
                billing_address: '支払先',
                property_name: '物件名',
                accrual_date: '発生日',
                due_date: '支払期日',
                deposit_date: '支払日',
                btn_billing_csv_download: '請求明細',
                btn_payment_csv_download: '支払明細',
                status_change: 'ステータス変更',
                payment_date: '入金日',
            }
        },
    },
}
