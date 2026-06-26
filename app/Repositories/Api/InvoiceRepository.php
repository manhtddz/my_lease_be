<?php

namespace App\Repositories\Api;

use App\Enums\PaymentStatusEnum;
use App\Models\Invoice;
use App\Repositories\CustomRepository;

class InvoiceRepository extends CustomRepository
{
    protected $model = Invoice::class;

    public function getListForSearch($dataSearch = [])
    {
        $roomId = data_get($dataSearch, 'room_id');
        $paymentStatus = data_get($dataSearch, 'payment_status');
        $note = data_get($dataSearch, 'note');

        $q = $this->select(['*'])
            ->when($roomId, function ($query) use ($roomId) {
                $query->where($this->modelField('room_id'), $roomId);
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
                'payments',
                'debt',
                'invoiceItems.debt',
                'invoiceItems.renovation',
            ])
            ->find($id);
    }

    public function getNotPaidInvoiceById($id)
    {
        return $this->newQuery()
            ->with([
                'room',
                'payments',
                'debt',
                'invoiceItems.debt',
                'invoiceItems.renovation',
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
