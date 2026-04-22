<?php

namespace App\Repositories\Api;

use App\Models\Room;
use App\Repositories\CustomRepository;

class RoomRepository extends CustomRepository
{
    protected $model = Room::class;

    public function getListForSearch($dataSearch = [])
    {
        $roomNumber = data_get($dataSearch, 'room_number');
        $floor = data_get($dataSearch, 'floor');
        $roomType = data_get($dataSearch, 'room_type');
        $maxOccupants = data_get($dataSearch, 'max_occupants');
        $status = data_get($dataSearch, 'status');

        $q = $this->select(['*'])
            ->when($roomNumber, function ($query) use ($roomNumber) {
                $query->whereLike($this->modelField('room_number'), $roomNumber);
            })
            ->when($floor, function ($query) use ($floor) {
                $query->whereLike($this->modelField('floor'), $floor);
            })
            ->when($roomType, function ($query) use ($roomType) {
                $query->whereLike($this->modelField('room_type'), $roomType);
            })
            ->when($maxOccupants, function ($query) use ($maxOccupants) {
                $query->where($this->modelField('max_occupants'), $maxOccupants);
            })
            ->when($status, function ($query) use ($status) {
                $query->where($this->modelField('status'), $status);
            });

        return $q->paginate(getConstant('PER_PAGE_DEFAULT'));
    }
}
