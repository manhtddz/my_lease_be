<?php

namespace App\Repositories\Api;

use App\Enums\IsPresentativeEnum;
use App\Models\TenantRoomHistory;
use App\Repositories\CustomRepository;

class TenantRoomHistoryRepository extends CustomRepository
{
    protected $model = TenantRoomHistory::class;

    public function getListForSearch($dataSearch = [])
    {
        $tenantId = data_get($dataSearch, 'tenant_id');
        $roomId = data_get($dataSearch, 'room_id');
        $moveInDate = data_get($dataSearch, 'move_in_date');
        $moveOutDate = data_get($dataSearch, 'move_out_date');
        $isRepresentative = data_get($dataSearch, 'is_representative');
        $roomPriceSnapshot = data_get($dataSearch, 'room_price_snapshot');
        $note = data_get($dataSearch, 'note');

        $q = $this->select(['*'])
            ->when($tenantId, function ($query) use ($tenantId) {
                $query->where($this->modelField('tenant_id'), $tenantId);
            })
            ->when($roomId, function ($query) use ($roomId) {
                $query->where($this->modelField('room_id'), $roomId);
            })
            ->when($moveInDate, function ($query) use ($moveInDate) {
                $query->where($this->modelField('move_in_date'), $moveInDate);
            })
            ->when($moveOutDate, function ($query) use ($moveOutDate) {
                $query->where($this->modelField('move_out_date'), $moveOutDate);
            })
            ->when($isRepresentative, function ($query) use ($isRepresentative) {
                $query->where($this->modelField('is_representative'), $isRepresentative);
            })
            ->when($roomPriceSnapshot, function ($query) use ($roomPriceSnapshot) {
                $query->where($this->modelField('room_price_snapshot'), $roomPriceSnapshot);
            })
            ->when($note, function ($query) use ($note) {
                $query->whereLike($this->modelField('note'), $note);
            });

        return $q->paginate(getConstant('PER_PAGE_DEFAULT'));
    }

    public function getOccupiedByRoomIdAndTenantId($tenantIds, $roomId)
    {
        return $this->where('room_id', $roomId)
            ->whereIn('tenant_id', $tenantIds)
            ->where(function ($query) {
                $query->whereNull($this->modelField('move_out_date'))
                    ->orWhere($this->modelField('move_out_date'), '>=', now());
            })->get();
    }

    public function countActiveTenantsInRoom($roomId)
    {
        return $this->where($this->modelField('room_id'), $roomId)
            ->where(function ($query) {
                $query->whereNull($this->modelField('move_out_date'))
                    ->orWhere($this->modelField('move_out_date'), '>=', now());
            })->count();
    }

    public function hasRepresentativeInRoom($roomId)
    {
        return $this->where($this->modelField('room_id'), $roomId)
            ->where($this->modelField('is_representative'), IsPresentativeEnum::TRUE)
            ->where(function ($query) {
                $query->whereNull($this->modelField('move_out_date'))
                    ->orWhere($this->modelField('move_out_date'), '>=', now());
            })->exists();
    }

    public function getRepresentativeInRoom($roomId)
    {
        return $this->where($this->modelField('room_id'), $roomId)
            ->where($this->modelField('is_representative'), IsPresentativeEnum::TRUE)
            ->where(function ($query) {
                $query->whereNull($this->modelField('move_out_date'))
                    ->orWhere($this->modelField('move_out_date'), '>=', now());
            })->first();
    }

    public function getTenantHistoryByRoomIdAndTenantId($roomId, $tenantId)
    {
        return $this->where($this->modelField('room_id'), $roomId)
            ->where($this->modelField('tenant_id'), $tenantId)
            ->where(function ($query) {
                $query->whereNull($this->modelField('move_out_date'))
                    ->orWhere($this->modelField('move_out_date'), '>=', now());
            })->first(); 
    }
}
