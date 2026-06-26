<?php

namespace App\Repositories\Api;

use App\Enums\PaymentStatusEnum;
use App\Models\Invoice;
use App\Models\Room;
use App\Models\Tenant;
use App\Repositories\CustomRepository;

class InvoiceRepository extends CustomRepository
{
    protected $model = Invoice::class;

    public function getListForSearch($dataSearch = [])
    {
        $roomId = data_get($dataSearch, 'room_id');
        $room_number = data_get($dataSearch, 'room_number');
        $representativeTenantId = data_get($dataSearch, 'representative_tenant_id');
        $representativeTenantName = data_get($dataSearch, 'representative_tenant_name');
        $totalAmount = data_get($dataSearch, 'total_amount');
        $paymentStatus = data_get($dataSearch, 'payment_status');
        $note = data_get($dataSearch, 'note');
        $sortBy = data_get($dataSearch, 'sort_by', 'id');
        $sortDir = data_get($dataSearch, 'sort_dir', 'asc');
        $size = data_get($dataSearch, 'size', getConstant('PER_PAGE_DEFAULT'));

        $q = $this->with([
            'room' => function ($query) {
                $query->select(Room::field('id'), Room::field('room_number'));
            },
            'representative' => function ($query) {
                $query->select(Tenant::field('id'), Tenant::field('name'));
            },
        ])
            ->select(['*'])
            ->when($roomId, function ($query) use ($roomId) {
                $query->where($this->modelField('room_id'), $roomId);
            })
            ->when($room_number, function ($query) use ($room_number) {
                $query->whereHas('room', function ($qRoom) use ($room_number) {
                    $qRoom->whereLike(Room::field('room_number'), $room_number);
                });
            })
            ->when($representativeTenantName, function ($query) use ($representativeTenantName) {
                $query->whereHas('representative', function ($qRepresentative) use ($representativeTenantName) {
                    $qRepresentative->whereLike(Tenant::field('name'), $representativeTenantName);
                });
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
            })->orderBy($sortBy, $sortDir);

        return $q->paginate($size);
    }

    public function findForShow($id)
    {
        return $this->newQuery()
            ->with([
                'room',
                'payments',
                'invoiceItems',
            ])
            ->find($id);
    }

    public function getNotPaidInvoiceById($id)
    {
        return $this->newQuery()
            ->with([
                'room',
                'payments',
                'invoiceItems',
            ])
            ->where($this->modelField('id'), $id)
            ->whereIn($this->modelField('payment_status'), PaymentStatusEnum::getUnpaidStatus())
            ->first();
    }

    /**
     * Invoices that are still unpaid (or partially paid) and whose creation date
     * is older than the given threshold — i.e. payment is overdue.
     */
    public function getOverdueUnpaidInvoices($overdueBefore)
    {
        return $this->newQuery()
            ->whereIn($this->modelField('payment_status'), PaymentStatusEnum::getUnpaidStatus())
            ->where($this->modelField('created_at'), '<=', $overdueBefore)
            ->get();
    }
}
