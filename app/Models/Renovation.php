<?php

namespace App\Models;

use App\Enums\ActiveStatusEnum;
use App\Enums\PaidByEnum;
use App\Models\Base\CustomModel;

class Renovation extends CustomModel
{
    protected $table = 'renovations';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'modified_at';

    protected $fillable = [
        'room_id',
        'tenant_id',
        'name',
        'amount',
        'issue_date',
        'paid_by', // 1. Owner, 2. Tenant
        'status', // 1. Active, 0. Cancelled
        'note',
        'del_flag'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class, 'renovation_id');
    }

    protected $casts = [
        'paid_by' => PaidByEnum::class,
        'status'  => ActiveStatusEnum::class,
    ];
}
