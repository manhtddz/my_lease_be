<?php

namespace App\Models;

use App\Enums\ActiveStatusEnum;
use App\Enums\PaymentMethodEnum;
use App\Models\Base\CustomModel;

class Payment extends CustomModel
{
    protected $table = 'payments';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'modified_at';

    protected $fillable = [
        'invoice_id',
        'tenant_id',
        'payment_amount',
        'payment_date',
        'payment_method', // 1. banking 2. cash
        'payment_status', // 1. Active, 0. Cancelled
        'note',
        'del_flag'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    protected $casts = [
        'payment_method' => PaymentMethodEnum::class,
        'payment_status' => ActiveStatusEnum::class,
    ];
}