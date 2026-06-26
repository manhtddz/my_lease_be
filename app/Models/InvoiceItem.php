<?php

namespace App\Models;

use App\Enums\ItemTypeEnum;
use App\Models\Base\CustomModel;

class InvoiceItem extends CustomModel
{
    protected $table = 'invoice_items';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'modified_at';

    protected $fillable = [
        'invoice_id',
        'item_type', // 1: Electricity, 2: Water, 3: Occupied, 4: Debt, 5: Renovation
        'item_name',
        'amount',
        'note',
        'debt_id',
        'renovation_id',
        'room_consumption_id',
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

    public function debt()
    {
        return $this->belongsTo(Debt::class, 'debt_id');
    }

    public function renovation()
    {
        return $this->belongsTo(Renovation::class, 'renovation_id');
    }

    protected $casts = [
        'item_type' => ItemTypeEnum::class,
    ];
}
