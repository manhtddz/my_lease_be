<?php

namespace App\Repositories\Api;

use App\Models\Payment;
use App\Repositories\CustomRepository;

class PaymentRepository extends CustomRepository
{
    protected $model = Payment::class;

    public function getListForSearch($dataSearch = [])
    {
        $invoiceId = data_get($dataSearch, 'invoice_id');
        $tenantId = data_get($dataSearch, 'tenant_id');
        $paymentAmount = data_get($dataSearch, 'payment_amount');
        $paymentDate = data_get($dataSearch, 'payment_date');
        $paymentMethod = data_get($dataSearch, 'payment_method');
        $paymentStatus = data_get($dataSearch, 'payment_status');
        $note = data_get($dataSearch, 'note');

        $q = $this->select(['*'])
            ->when($invoiceId, function ($query) use ($invoiceId) {
                $query->where($this->modelField('invoice_id'), $invoiceId);
            })
            ->when($tenantId, function ($query) use ($tenantId) {
                $query->where($this->modelField('tenant_id'), $tenantId);
            })
            ->when($paymentAmount, function ($query) use ($paymentAmount) {
                $query->where($this->modelField('payment_amount'), $paymentAmount);
            })
            ->when($paymentDate, function ($query) use ($paymentDate) {
                $query->where($this->modelField('payment_date'), $paymentDate);
            })
            ->when($paymentMethod, function ($query) use ($paymentMethod) {
                $query->where($this->modelField('payment_method'), $paymentMethod);
            })
            ->when($paymentStatus, function ($query) use ($paymentStatus) {
                $query->where($this->modelField('payment_status'), $paymentStatus);
            })
            ->when($note, function ($query) use ($note) {
                $query->whereLike($this->modelField('note'), $note);
            });

        return $q->paginate(getConstant('PER_PAGE_DEFAULT'));
    }
}
