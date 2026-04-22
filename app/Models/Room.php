<?php

namespace App\Models;

use App\Models\Base\CustomModel;
use Illuminate\Database\Eloquent\Model;

class Room extends CustomModel
{
    protected $table = 'rooms';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'modified_at';

    protected $fillable = [
        'room_number',
        'floor',
        'room_type',
        'room_price',
        'max_occupants',
        'status',
        'del_flag'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    // Lịch sử thuê phòng
    public function tenantHistories()
    {
        return $this->hasMany(TenantRoomHistory::class, 'room_id');
    }

    // Consumption theo tháng
    public function consumptions()
    {
        return $this->hasMany(RoomConsumption::class, 'room_id');
    }

    // Hóa đơn
    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'room_id');
    }

    // Chi phí nâng cấp phòng
    public function sidePaids()
    {
        return $this->hasMany(RoomSidePaid::class, 'room_id');
    }
}