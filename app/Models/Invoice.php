<?php

namespace App\Models;

use App\Enums\PaymentStatusEnum;
use App\Models\Base\CustomModel;

class Invoice extends CustomModel
{
    protected $table = 'invoices';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'modified_at';

    protected $fillable = [
        'room_id',
        'payment_status', // 1. Initial, 2. Paid, 3. Partially Paid, 4. Not Paid Overdue
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

    public function payments()
    {
        return $this->hasMany(Payment::class, 'invoice_id');
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }

    protected $casts = [
        'payment_status' => PaymentStatusEnum::class,
    ];
}
