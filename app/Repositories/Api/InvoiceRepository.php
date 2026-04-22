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
        $roomConsumptionId = data_get($dataSearch, 'room_consumption_id');
        $representativeTenantId = data_get($dataSearch, 'representative_tenant_id');
        $electricityAmount = data_get($dataSearch, 'electricity_amount');
        $waterAmount = data_get($dataSearch, 'water_amount');
        $roomAmount = data_get($dataSearch, 'room_amount');
        $extraAmount = data_get($dataSearch, 'extra_amount');
        $totalAmount = data_get($dataSearch, 'total_amount');
        $paymentStatus = data_get($dataSearch, 'payment_status');
        $note = data_get($dataSearch, 'note');

        $q = $this->select(['*'])
            ->when($roomId, function ($query) use ($roomId) {
                $query->where($this->modelField('room_id'), $roomId);
            })
            ->when($roomConsumptionId, function ($query) use ($roomConsumptionId) {
                $query->where($this->modelField('room_consumption_id'), $roomConsumptionId);
            })
            ->when($representativeTenantId, function ($query) use ($representativeTenantId) {
                $query->where($this->modelField('representative_tenant_id'), $representativeTenantId);
            })
            ->when($electricityAmount, function ($query) use ($electricityAmount) {
                $query->where($this->modelField('electricity_amount'), $electricityAmount);
            })
            ->when($waterAmount, function ($query) use ($waterAmount) {
                $query->where($this->modelField('water_amount'), $waterAmount);
            })
            ->when($roomAmount, function ($query) use ($roomAmount) {
                $query->where($this->modelField('room_amount'), $roomAmount);
            })
            ->when($extraAmount, function ($query) use ($extraAmount) {
                $query->where($this->modelField('extra_amount'), $extraAmount);
            })
            ->when($totalAmount, function ($query) use ($totalAmount) {
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
}
