<?php

namespace App\Repositories\Api;

use App\Models\InvoiceRoomConsumption;
use App\Repositories\CustomRepository;

class InvoiceRoomConsumptionRepository extends CustomRepository
{
    protected $model = InvoiceRoomConsumption::class;

    public function getListForSearch($dataSearch = [])
    {
        $invoiceId = data_get($dataSearch, 'invoice_id');
        $roomConsumptionId = data_get($dataSearch, 'room_consumption_id');
        $allocatedAmount = data_get($dataSearch, 'allocated_amount');

        $q = $this->select(['*'])
            ->when($invoiceId, function ($query) use ($invoiceId) {
                $query->where($this->modelField('invoice_id'), $invoiceId);
            })
            ->when($roomConsumptionId, function ($query) use ($roomConsumptionId) {
                $query->where($this->modelField('room_consumption_id'), $roomConsumptionId);
            })
            ->when($allocatedAmount !== null && $allocatedAmount !== '', function ($query) use ($allocatedAmount) {
                $query->where($this->modelField('allocated_amount'), $allocatedAmount);
            });

        return $q->paginate(getConstant('PER_PAGE_DEFAULT'));
    }
}
