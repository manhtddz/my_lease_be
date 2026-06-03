<?php

namespace App\Services\Api;

use App\Enums\IsPresentativeEnum;
use App\Repositories\Api\TenantRepository;
use App\Repositories\Api\TenantRoomHistoryRepository;
use App\Services\CustomService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TenantService extends CustomService
{
    public function __construct(
        public TenantRepository $tenantRepository,
        public TenantRoomHistoryRepository $tenantRoomHistoryRepository,
        public RoomConsumptionService $roomConsumptionService
    ) {
        parent::__construct();
    }

    public function getListForSearch($dataSearch = [])
    {
        return $this->tenantRepository->getListForSearch($dataSearch);
    }

    public function store($params)
    {
        try {
            $this->tenantRepository->create($params);
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            return false;
        }

        return true;
    }

    public function getById($id)
    {
        return $this->tenantRepository->find($id);
    }

    public function update($id, $params)
    {
        try {
            $this->tenantRepository->update($id, $params);
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            return false;
        }

        return true;
    }

    public function delete($id)
    {
        try {
            $this->tenantRepository->delete($id);
        } catch (\Throwable $exception) {
            logInfo($exception->getMessage());
            return false;
        }

        return true;
    }

    public function storeAndAssign($params, $roomId, $consumptionData = [])
    {
        if ($params['is_representative'] && $this->tenantRoomHistoryRepository->hasRepresentativeInRoom($roomId)) {
            throw ValidationException::withMessages(['is_representative' => [__('messages.room_already_has_representative')]]);
        }

        DB::beginTransaction();
        try {
            $tenant = $this->tenantRepository->create($params);

            $this->tenantRoomHistoryRepository->create([
                'tenant_id' => $tenant->id,
                'room_id' => $roomId,
                'move_in_date' => now(),
                'is_representative' => $params['is_representative'],
                'note' => $params['note'] ?? null,
            ]);

            $activeConsumption = $this->roomConsumptionService->getActiveConsumptionByRoomId($roomId);
            if (!$activeConsumption) {
                $this->roomConsumptionService->startConsumption($roomId, $consumptionData);
            }

            DB::commit();
            return true;
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function setRepresentation($tenantId, $roomId)
    {
        $representTenant = $this->tenantRoomHistoryRepository->getRepresentativeInRoom($roomId);

        $targetTenant = $this->tenantRoomHistoryRepository->getTenantHistoryByRoomIdAndTenantId($roomId, $tenantId);

        DB::beginTransaction();
        try {
            if ($representTenant) {
                $representTenant->update(['is_representative' => IsPresentativeEnum::FALSE]);
            }
            $targetTenant->update(['is_representative' => IsPresentativeEnum::TRUE]);

            DB::commit();
            return true;
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }

    public function assignToRoom($params, $roomId, $tenantId)
    {
        if ($params['is_representative'] && $this->tenantRoomHistoryRepository->hasRepresentativeInRoom($roomId)) {
            throw ValidationException::withMessages(['is_representative' => [__('messages.room_already_has_representative')]]);
        }

        DB::beginTransaction();
        try {
            $this->tenantRoomHistoryRepository->create([
                'tenant_id' => $tenantId,
                'room_id' => $roomId,
                'move_in_date' => now(),
                'is_representative' => $params['is_representative'],
                'note' => $params['note'] ?? null,
            ]);

            $activeConsumption = $this->roomConsumptionService->getActiveConsumptionByRoomId($roomId);
            if (!$activeConsumption) {
                $consumptionData = [
                    'electricityUnitPrice' => $params['electricityUnitPrice'] ?? null,
                    'waterUnitPrice' => $params['waterUnitPrice'] ?? null,
                    'occupiedUnitPrice' => $params['occupiedUnitPrice'] ?? null,
                    'note' => null,
                ];
                
                $this->roomConsumptionService->startConsumption($roomId, $consumptionData);
            }

            DB::commit();
            return true;
        } catch (\Throwable $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
