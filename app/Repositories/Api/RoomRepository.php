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
        $sortBy = data_get($dataSearch, 'sort_by', 'id');
        $sortDir = data_get($dataSearch, 'sort_dir', 'asc');
        $size = data_get($dataSearch, 'size', getConstant('PER_PAGE_DEFAULT'));

        $q = $this->select(['*'])
            ->when($roomNumber, function ($query) use ($roomNumber) {
                $query->whereLike($this->modelField('room_number'), $roomNumber);
            })
            ->when($floor, function ($query) use ($floor) {
                $query->whereLike($this->modelField('floor'), $floor);
            })
            ->when($roomType, function ($query) use ($roomType) {
                $query->whereIn($this->modelField('room_type'), $roomType);
            })
            ->when($maxOccupants, function ($query) use ($maxOccupants) {
                $query->where($this->modelField('max_occupants'), $maxOccupants);
            })
            ->when($status, function ($query) use ($status) {
                $query->whereIn($this->modelField('status'), $status);
            });

        return $q->orderBy($sortBy, $sortDir)->paginate($size);
    }
}
