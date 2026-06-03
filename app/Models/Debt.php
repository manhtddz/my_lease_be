<?php

namespace App\Models;

use App\Enums\ActiveStatusEnum;
use App\Enums\DebtTypeEnum;
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
        'penalty_amount',
        'debt_type', // 1: Owner Debt, 2: Tenant Debt
        'due_date',
        'status', // 1. Active, 0. Cancelled
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

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class, 'debt_id');
    }

    protected $casts = [
        'debt_type' => DebtTypeEnum::class,
        'status'    => ActiveStatusEnum::class,
    ];
}