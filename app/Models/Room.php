<?php

namespace App\Models;

use App\Enums\RoomStatusEnum;
use App\Enums\RoomTypeEnum;
use App\Models\Base\CustomModel;

class Room extends CustomModel
{
    protected $table = 'rooms';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'modified_at';

    protected $fillable = [
        'room_number',
        'floor',
        'room_type', // 1. Single, 2. Double, 3. Triple, 4. Quadruple, 5. Family
        'room_price',
        'max_occupants',
        'status', // 0. Available, 1. Partially Occupied, 2. Fully Occupied, 3. Reserved
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
    public function renovations()
    {
        return $this->hasMany(Renovation::class, 'room_id');
    }

    public function currentTenants()
    {
        return $this->belongsToMany(Tenant::class, TenantRoomHistory::getTableName(), 'room_id', 'tenant_id')
            ->withPivot('move_in_date', 'move_out_date', 'is_representative', 'room_price_snapshot', 'note')
            ->where(function ($query) {
                $query->whereNull(TenantRoomHistory::field('move_out_date'))
                    ->orWhere(TenantRoomHistory::field('move_out_date'), '>', now());
            });
    }

    public function currentTenantHistories()
    {
        return $this->hasMany(TenantRoomHistory::class, 'room_id')
            ->whereNull(TenantRoomHistory::field('move_out_date'))
            ->orWhere(TenantRoomHistory::field('move_out_date'), '>=', now());
    }

    protected $casts = [
        'room_type' => RoomTypeEnum::class,
        'status'    => RoomStatusEnum::class,
    ];
}
