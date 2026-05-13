<?php

namespace App\Repositories\Api;

use App\Models\Invoice;
use App\Repositories\CustomRepository;

class InvoiceRepository extends CustomRepository
{
    protected $model = Invoice::class;

    public function getListForSearch($dataSearch = [])
    {
        $roomId = data_get($dataSearch, 'room_id');
        $representativeTenantId = data_get($dataSearch, 'representative_tenant_id');
        $totalAmount = data_get($dataSearch, 'total_amount');
        $paymentStatus = data_get($dataSearch, 'payment_status');
        $note = data_get($dataSearch, 'note');

        $q = $this->select(['*'])
            ->when($roomId, function ($query) use ($roomId) {
                $query->where($this->modelField('room_id'), $roomId);
            })
            ->when($representativeTenantId, function ($query) use ($representativeTenantId) {
                $query->where($this->modelField('representative_tenant_id'), $representativeTenantId);
            })
            ->when($totalAmount !== null && $totalAmount !== '', function ($query) use ($totalAmount) {
                $query->where($this->modelField('total_amount'), $totalAmount);
            })
            ->when($paymentStatus, function ($query) use ($paymentStatus) {
                $query->where($this->modelField('payment_status'), $paymentStatus);
            })
            ->when($note, function ($query) use ($note) {
                $query->whereLike($this->modelField('note'), $note);
            });

        return $q->paginate(getConstant('PER_PAGE_DEFAULT'));
    }

    public function findForShow($id)
    {
        return $this->newQuery()
            ->with([
                'room',
                'representative',
                'payments',
                'debt',
                'invoiceItems.debt',
                'invoiceItems.roomSidePaid',
                'invoiceRoomConsumptions.roomConsumption',
            ])
            ->find($id);
    }
}
