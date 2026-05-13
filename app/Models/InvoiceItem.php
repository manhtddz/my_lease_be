<?php

namespace App\Models;

use App\Models\Base\CustomModel;

class InvoiceItem extends CustomModel
{
    protected $table = 'invoice_items';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'modified_at';

    protected $fillable = [
        'invoice_id',
        'item_type', // 1: Electricity, 2: Water, 3: Occupied, 4: Debt, 5: Room Side Paid
        'item_name',
        'amount',
        'note',
        'debt_id',
        'room_side_paid_id',
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

    public function debt()
    {
        return $this->belongsTo(Debt::class, 'debt_id');
    }

    public function roomSidePaid()
    {
        return $this->belongsTo(RoomSidePaid::class, 'room_side_paid_id');
    }
}
