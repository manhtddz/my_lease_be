<?php

namespace App\Repositories\Api;

use App\Models\RoomConsumption;
use App\Repositories\CustomRepository;

class RoomConsumptionRepository extends CustomRepository
{
    protected $model = RoomConsumption::class;

    public function getListForSearch($dataSearch = [])
    {
        $roomId = data_get($dataSearch, 'room_id');
        $billingYear = data_get($dataSearch, 'billing_year');
        $billingMonth = data_get($dataSearch, 'billing_month');
        $electricityOld = data_get($dataSearch, 'electricity_old');
        $electricityNew = data_get($dataSearch, 'electricity_new');
        $electricityUnitPrice = data_get($dataSearch, 'electricity_unit_price');
        $waterOld = data_get($dataSearch, 'water_old');
        $waterNew = data_get($dataSearch, 'water_new');
        $waterUnitPrice = data_get($dataSearch, 'water_unit_price');
        $startOccupiedDate = data_get($dataSearch, 'start_occupied_date');
        $stopOccupiedDate = data_get($dataSearch, 'stop_occupied_date');
        $note = data_get($dataSearch, 'note');

        $q = $this->select(['*'])
            ->when($roomId, function ($query) use ($roomId) {
                $query->where($this->modelField('room_id'), $roomId);
            })
            ->when($billingYear, function ($query) use ($billingYear) {
                $query->where($this->modelField('billing_year'), $billingYear);
            })
            ->when($billingMonth, function ($query) use ($billingMonth) {
                $query->where($this->modelField('billing_month'), $billingMonth);
            })
            ->when($electricityOld, function ($query) use ($electricityOld) {
                $query->where($this->modelField('electricity_old'), $electricityOld);
            })
            ->when($electricityNew, function ($query) use ($electricityNew) {
                $query->where($this->modelField('electricity_new'), $electricityNew);
            })
            ->when($electricityUnitPrice, function ($query) use ($electricityUnitPrice) {
                $query->where($this->modelField('electricity_unit_price'), $electricityUnitPrice);
            })
            ->when($waterOld, function ($query) use ($waterOld) {
                $query->where($this->modelField('water_old'), $waterOld);
            })
            ->when($waterNew, function ($query) use ($waterNew) {
                $query->where($this->modelField('water_new'), $waterNew);
            })
            ->when($waterUnitPrice, function ($query) use ($waterUnitPrice) {
                $query->where($this->modelField('water_unit_price'), $waterUnitPrice);
            })
            ->when($startOccupiedDate, function ($query) use ($startOccupiedDate) {
                $query->where($this->modelField('start_occupied_date'), $startOccupiedDate);
            })
            ->when($stopOccupiedDate, function ($query) use ($stopOccupiedDate) {
                $query->where($this->modelField('stop_occupied_date'), $stopOccupiedDate);
            })
            ->when($note, function ($query) use ($note) {
                $query->whereLike($this->modelField('note'), $note);
            });

        return $q->paginate(getConstant('PER_PAGE_DEFAULT'));
    }
}
