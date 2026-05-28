<?php

namespace App\Services\Api;

use App\Enums\RoomStatusEnum;
use App\Models\Room;
use App\Models\Tenant;
use App\Repositories\Api\RoomRepository;
use App\Repositories\Api\TenantRoomHistoryRepository;
use App\Services\CustomService;

class RoomService extends CustomService
{
    public function __construct(
        public RoomRepository $roomRepository,
        public TenantRoomHistoryRepository $tenantRoomHistoryRepository
    ) {
        parent::__construct();
    }

    public function getListForSearch($dataSearch = [])
    {
        return $this->roomRepository->getListForSearch($dataSearch);
    }

    public function store($params)
    {
        try {
            if (empty($params['status'])) {
                $params['status'] = RoomStatusEnum::AVAILABLE;
            }
            $this->roomRepository->create($params);
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            return false;
        }

        return true;
    }

    public function getById($id)
    {
        return $this->roomRepository->find($id);
    }

    public function update($id, $params)
    {
        try {
            if (empty($params['status'])) {
                $params['status'] = RoomStatusEnum::AVAILABLE;
            }
            $this->roomRepository->update($id, $params);
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            return false;
        }

        return true;
    }

    public function delete($id)
    {
        try {
            $this->roomRepository->delete($id);
        } catch (\Throwable $exception) {
            logInfo($exception->getMessage());
            return false;
        }

        return true;
    }

    public function getCurrentTenants(Room $room)
    {
        return $room->currentTenants()->get();
    }

    public function moveOut($roomId, $tenantId)
    {
        try {
            $history = $this->tenantRoomHistoryRepository->getOccupiedByRoomIdAndTenantId($roomId, $tenantId);

            if (empty($history)) {
                return false;
            }

            $this->tenantRoomHistoryRepository->update($history->id, [
                'move_out_date' => now(),
            ]);
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            return false;
        }

        return true;
    }

    public function moveOutAll(Room $room)
    {
        try {
            $room->currentTenantHistories()->update([
                'move_out_date' => now(),
            ]);
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            return false;
        }
    }
}
