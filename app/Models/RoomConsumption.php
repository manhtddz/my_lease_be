<?php

namespace App\Models;

use App\Models\Base\CustomModel;

class RoomConsumption extends CustomModel
{
    protected $table = 'room_consumptions';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'modified_at';

    protected $fillable = [
        'room_id',
        'billing_year',
        'billing_month',
        'electricity_old',
        'electricity_new',
        'electricity_unit_price',
        'water_old',
        'water_new',
        'water_unit_price',
        'start_occupied_date',
        'stop_occupied_date',
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

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'room_consumption_id');
    }
}