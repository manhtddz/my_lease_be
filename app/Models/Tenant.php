<?php

namespace App\Models;

use App\Models\Base\CustomModel;

class Tenant extends CustomModel
{
    protected $table = 'tenants';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'modified_at';

    protected $fillable = [
        'name',
        'phone_number',
        'id_card_number',
        'del_flag'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    // Lịch sử thuê
    public function roomHistories()
    {
        return $this->hasMany(TenantRoomHistory::class, 'tenant_id');
    }

    // Payments
    public function payments()
    {
        return $this->hasMany(Payment::class, 'tenant_id');
    }

    // Debts
    public function debts()
    {
        return $this->hasMany(Debt::class, 'tenant_id');
    }

    // Hóa đơn đại diện
    public function representativeInvoices()
    {
        return $this->hasMany(Invoice::class, 'representative_tenant_id');
    }

    // Chi phí nâng cấp
    public function sidePaids()
    {
        return $this->hasMany(RoomSidePaid::class, 'tenant_id');
    }
}