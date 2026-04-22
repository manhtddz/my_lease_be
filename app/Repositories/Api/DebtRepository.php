<?php

namespace App\Repositories\Api;

use App\Models\Debt;
use App\Repositories\CustomRepository;

class DebtRepository extends CustomRepository
{
    protected $model = Debt::class;

    public function getListForSearch($dataSearch = [])
    {
        $invoiceId = data_get($dataSearch, 'invoice_id');
        $tenantId = data_get($dataSearch, 'tenant_id');
        $originalAmount = data_get($dataSearch, 'original_amount');
        $paidAmount = data_get($dataSearch, 'paid_amount');
        $remainingAmount = data_get($dataSearch, 'remaining_amount');
        $dueDate = data_get($dataSearch, 'due_date');
        $status = data_get($dataSearch, 'status');
        $note = data_get($dataSearch, 'note');

        $q = $this->select(['*'])
            ->when($invoiceId, function ($query) use ($invoiceId) {
                $query->where($this->modelField('invoice_id'), $invoiceId);
            })
            ->when($tenantId, function ($query) use ($tenantId) {
                $query->where($this->modelField('tenant_id'), $tenantId);
            })
            ->when($originalAmount, function ($query) use ($originalAmount) {
                $query->where($this->modelField('original_amount'), $originalAmount);
            })
            ->when($paidAmount, function ($query) use ($paidAmount) {
                $query->where($this->modelField('paid_amount'), $paidAmount);
            })
            ->when($remainingAmount, function ($query) use ($remainingAmount) {
                $query->where($this->modelField('remaining_amount'), $remainingAmount);
            })
            ->when($dueDate, function ($query) use ($dueDate) {
                $query->where($this->modelField('due_date'), $dueDate);
            })
            ->when($status, function ($query) use ($status) {
                $query->where($this->modelField('status'), $status);
            })
            ->when($note, function ($query) use ($note) {
                $query->whereLike($this->modelField('note'), $note);
            });

        return $q->paginate(getConstant('PER_PAGE_DEFAULT'));
    }
}
