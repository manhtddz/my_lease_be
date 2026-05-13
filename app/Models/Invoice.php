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
        'representative_tenant_id',
        'total_amount',
        'payment_status', // 1. Initial, 2. Paid, 3. Partially Paid, 4. Not Paid Overdue
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

    public function roomConsumptions()
    {
        return $this->belongsToMany(
            RoomConsumption::class,
            'invoice_room_consumptions',
            'invoice_id',
            'room_consumption_id'
        )->withPivot('allocated_amount');
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
        return $this->hasMany(Debt::class, 'invoice_id');
    }

    public function invoiceItems()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }

    public function invoiceRoomConsumptions()
    {
        return $this->hasMany(InvoiceRoomConsumption::class, 'invoice_id');
    }
}
