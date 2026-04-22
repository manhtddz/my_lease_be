<?php

namespace App\Models;

use App\Models\Base\CustomModel;

class Debt extends CustomModel
{
    protected $table = 'debts';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'modified_at';

    protected $fillable = [
        'invoice_id',
        'tenant_id',
        'original_amount',
        'paid_amount',
        'remaining_amount',
        'due_date',
        'status',
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