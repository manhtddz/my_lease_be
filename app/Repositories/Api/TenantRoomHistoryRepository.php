<?php

namespace App\Repositories\Api;

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
}
