<?php

namespace App\Models;

use App\Models\Base\CustomModel;

class Invoice extends CustomModel
{
    protected $table = 'invoices';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'modified_at';

    protected $fillable = [
        'room_id',
        'room_consumption_id',
        'representative_tenant_id',
        'electricity_amount',
        'water_amount',
        'room_amount',
        'extra_amount',
        'total_amount',
        'payment_status',
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

    public function consumption()
    {
        return $this->belongsTo(
            RoomConsumption::class,
            'room_consumption_id'
        );
    }

    public function representative()
    {
        return $this->belongsTo(
            Tenant::class,
            'representative_tenant_id'
        );
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'invoice_id');
    }

    public function debt()
    {
        return $this->hasOne(Debt::class, 'invoice_id');
    }
}
