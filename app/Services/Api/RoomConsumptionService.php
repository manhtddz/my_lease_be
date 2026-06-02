<?php

namespace App\Services\Api;

use App\Repositories\Api\RoomConsumptionRepository;
use App\Services\CustomService;

class RoomConsumptionService extends CustomService
{
    public function __construct(
        public RoomConsumptionRepository $roomConsumptionRepository
    ) {
        parent::__construct();
    }

    public function getListForSearch($dataSearch = [])
    {
        return $this->roomConsumptionRepository->getListForSearch($dataSearch);
    }

    public function store($params)
    {
        try {
            $this->roomConsumptionRepository->create($params);
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            return false;
        }

        return true;
    }

    public function getById($id)
    {
        return $this->roomConsumptionRepository->find($id);
    }

    public function update($id, $params)
    {
        try {
            $this->roomConsumptionRepository->update($id, $params);
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            return false;
        }

        return true;
    }

    public function delete($id)
    {
        try {
            $this->roomConsumptionRepository->delete($id);
        } catch (\Throwable $exception) {
            logInfo($exception->getMessage());
            return false;
        }

        return true;
    }

    public function startConsumption($roomId, $data)
    {
        $latestConsumption = $this->getLatestConsumptionByRoomId($roomId);

        if (empty($latestConsumption)) {
            $electricityOld = 0;
            $waterOld = 0;
        } else {
            $electricityOld = $latestConsumption->electricity_new;
            $waterOld = $latestConsumption->water_new;
        }

        $this->roomConsumptionRepository->create([
            'room_id' => $roomId,
            'billing_year' => now()->year,
            'billing_month' => now()->month,
            'electricity_old' => $electricityOld,
            'electricity_new' => 0,
            'electricity_unit_price' => $data['electricityUnitPrice'],
            'water_old' => $waterOld,
            'water_new' => 0,
            'water_unit_price' => $data['waterUnitPrice'],
            'start_occupied_date' => now(),
            'stop_occupied_date' => null,
            'occupied_unit_price' => $data['occupiedUnitPrice'],
            'note' => $data['note'],
        ]);

        return true;
    }

    public function stopConsumption($consumptionId, $electricityNew = null, $waterNew = null, $note = null)
    {
        $this->roomConsumptionRepository->update($consumptionId, [
            'stop_occupied_date' => now(),
            'electricity_new' => $electricityNew ?? 0,
            'water_new' => $waterNew ?? 0,
            'note' => $note,
        ]);

        return true;
    }

    public function getLatestConsumptionByRoomId($roomId)
    {
        return $this->roomConsumptionRepository->getLatestConsumptionByRoomId($roomId);
    }

    public function getActiveConsumptionByRoomId($roomId)
    {
        return $this->roomConsumptionRepository->getActiveConsumptionByRoomId($roomId);
    }
}
