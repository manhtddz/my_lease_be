<?php

namespace App\Models;

use App\Models\Base\CustomModel;

class RoomSidePaid extends CustomModel
{
    protected $table = 'room_side_paids';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'modified_at';

    protected $fillable = [
        'room_id',
        'tenant_id',
        'name',
        'amount',
        'issue_date',
        'paid_by',
        'status',
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
}