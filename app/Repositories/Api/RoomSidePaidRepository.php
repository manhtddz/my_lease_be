<?php

namespace App\Repositories\Api;

use App\Models\RoomSidePaid;
use App\Repositories\CustomRepository;

class RoomSidePaidRepository extends CustomRepository
{
    protected $model = RoomSidePaid::class;

    public function getListForSearch($dataSearch = [])
    {
        $roomId = data_get($dataSearch, 'room_id');
        $tenantId = data_get($dataSearch, 'tenant_id');
        $name = data_get($dataSearch, 'name');
        $amount = data_get($dataSearch, 'amount');
        $issueDate = data_get($dataSearch, 'issue_date');
        $paidBy = data_get($dataSearch, 'paid_by');
        $status = data_get($dataSearch, 'status');
        $note = data_get($dataSearch, 'note');

        $q = $this->select(['*'])
            ->when($roomId, function ($query) use ($roomId) {
                $query->where($this->modelField('room_id'), $roomId);
            })
            ->when($tenantId, function ($query) use ($tenantId) {
                $query->where($this->modelField('tenant_id'), $tenantId);
            })
            ->when($name, function ($query) use ($name) {
                $query->whereLike($this->modelField('name'), $name);
            })
            ->when($amount, function ($query) use ($amount) {
                $query->where($this->modelField('amount'), $amount);
            })
            ->when($issueDate, function ($query) use ($issueDate) {
                $query->where($this->modelField('issue_date'), $issueDate);
            })
            ->when($paidBy, function ($query) use ($paidBy) {
                $query->where($this->modelField('paid_by'), $paidBy);
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
