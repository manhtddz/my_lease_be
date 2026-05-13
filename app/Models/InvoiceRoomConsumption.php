<?php

namespace App\Models;

use App\Models\Base\CustomModel;

class InvoiceRoomConsumption extends CustomModel
{
    protected $table = 'invoice_room_consumptions';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'modified_at';

    protected $fillable = [
        'invoice_id',
        'room_consumption_id',
        'allocated_amount',
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

    public function roomConsumption()
    {
        return $this->belongsTo(RoomConsumption::class, 'room_consumption_id');
    }
}
