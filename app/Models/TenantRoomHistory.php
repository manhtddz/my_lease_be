<?php

namespace App\Models;

use App\Models\Base\CustomModel;

class TenantRoomHistory extends CustomModel
{
    protected $table = 'tenant_room_history';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'modified_at';

    protected $fillable = [
        'tenant_id',
        'room_id',
        'move_in_date',
        'move_out_date',
        'is_representative',
        'room_price_snapshot',
        'note',
        'del_flag'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenant_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}