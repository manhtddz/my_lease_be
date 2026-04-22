<?php

namespace App\Models;

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
        'payment_method',
        'payment_status',
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
}