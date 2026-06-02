<?php

namespace App\Services\Api;

use App\Enums\IsPresentativeEnum;
use App\Models\Room;
use App\Repositories\Api\TenantRoomHistoryRepository;
use App\Services\CustomService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TenantRoomHistoryService extends CustomService
{
    public function __construct(
        public TenantRoomHistoryRepository $tenantRoomHistoryRepository,
        public RoomConsumptionService $roomConsumptionService
    ) {
        parent::__construct();
    }

    public function getListForSearch($dataSearch = [])
    {
        return $this->tenantRoomHistoryRepository->getListForSearch($dataSearch);
    }

    public function store($params)
    {
        try {
            $this->tenantRoomHistoryRepository->create($params);
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            return false;
        }

        return true;
    }

    public function getById($id)
    {
        return $this->tenantRoomHistoryRepository->find($id);
    }

    public function update($id, $params)
    {
        try {
            $this->tenantRoomHistoryRepository->update($id, $params);
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            return false;
        }

        return true;
    }

    public function delete($id)
    {
        try {
            $this->tenantRoomHistoryRepository->delete($id);
        } catch (\Throwable $exception) {
            logInfo($exception->getMessage());
            return false;
        }

        return true;
    }

    public function moveTenantsOut($tenantIds, $roomId)
    {
        $histories = $this->tenantRoomHistoryRepository->getOccupiedByRoomIdAndTenantId($tenantIds, $roomId);

        if ($histories->isEmpty()) {
            throw ValidationException::withMessages(['tenantIds' => [__('messages.no_data')]]);
        }

        $totalActive = $this->tenantRoomHistoryRepository->countActiveTenantsInRoom($roomId);
        $allMovedOut = $histories->count() >= $totalActive;

        DB::beginTransaction();
        try {
            $this->markHistoriesMovedOut($histories);
            $this->stopConsumptionIfRoomEmpty($roomId, $allMovedOut);

            DB::commit();
            return true;
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function moveOutAll(Room $room)
    {
        DB::beginTransaction();
        try {
            $room->currentTenantHistories()->update([
                'move_out_date' => now(),
            ]);

            $this->stopConsumptionIfRoomEmpty($room->id, true);
            DB::commit();
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            DB::rollBack();
            return false;
        }

        return true;

    }

    public function transferTenantToRoom($tenantIds, $sourceRoomId, $destRoomId, $consumptionData = [])
    {
        $histories = $this->tenantRoomHistoryRepository->getOccupiedByRoomIdAndTenantId($tenantIds, $sourceRoomId);

        if ($histories->isEmpty()) {
            throw ValidationException::withMessages(['tenantIds' => [__('messages.no_data')]]);
        }

        $totalActiveInSource = $this->tenantRoomHistoryRepository->countActiveTenantsInRoom($sourceRoomId);
        $allTransferred = $histories->count() >= $totalActiveInSource;

        DB::beginTransaction();
        try {
            $this->markHistoriesMovedOut($histories);

            foreach ($histories as $history) {
                $this->tenantRoomHistoryRepository->create([
                    'tenant_id' => $history->tenant_id,
                    'room_id' => $destRoomId,
                    'move_in_date' => now(),
                    'is_representative' => false,
                ]);
            }

            $this->stopConsumptionIfRoomEmpty($sourceRoomId, $allTransferred);
            $this->startConsumptionIfNeeded($destRoomId, $consumptionData);

            DB::commit();
            return true;
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    private function markHistoriesMovedOut($histories)
    {
        foreach ($histories as $history) {
            if ($history->is_representative->value == IsPresentativeEnum::TRUE) {
                throw ValidationException::withMessages(['tenantIds' => [__('messages.tenant_is_representative')]]);
            }

            $this->tenantRoomHistoryRepository->update($history->id, [
                'move_out_date' => now(),
            ]);
        }
    }

    private function stopConsumptionIfRoomEmpty($roomId, $allLeft)
    {
        if (!$allLeft) {
            return;
        }

        $activeConsumption = $this->roomConsumptionService->getActiveConsumptionByRoomId($roomId);
        if ($activeConsumption) {
            $this->roomConsumptionService->stopConsumption($activeConsumption->id);
        }
    }

    private function startConsumptionIfNeeded($destRoomId, $consumptionData)
    {
        $activeConsumption = $this->roomConsumptionService->getActiveConsumptionByRoomId($destRoomId);
        if (!$activeConsumption) {
            $this->roomConsumptionService->startConsumption($destRoomId, $consumptionData);
        }
    }
}
