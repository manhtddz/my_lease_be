<?php

namespace App\Services\Api;

use App\Repositories\Api\RoomConsumptionRepository;
use App\Services\CustomService;
use Carbon\Carbon;

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

    public function getById($id, $isDone = false)
    {
        $rq = $this->roomConsumptionRepository->find($id);
        $stopOccupiedDate = $rq->stop_occupied_date;
        if ($isDone) {
            if ($stopOccupiedDate && $stopOccupiedDate <= now()) {
                return $rq;
            }
    
            return null;
        } else {
            return $rq;
        }
        
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

    public function checkConsumptionBelongsToRoom($consumptionIds, $roomId)
    {
        $consumptionIds = (array) $consumptionIds;

        if (empty($consumptionIds)) {
            return false;
        }

        $matchCount = $this->roomConsumptionRepository
            ->whereIn($this->roomConsumptionRepository->modelField('id'), $consumptionIds)
            ->where($this->roomConsumptionRepository->modelField('room_id'), $roomId)
            ->count();

        return $matchCount === count($consumptionIds);
    }

    public function calculateAllConsumptionPrice($consumption)
    {
        if (empty($consumption)) {
            throw new \Exception('Consumption not found');
        }

        $electricityPrice = $this->calculateElectricityPrice($consumption->electricity_old, $consumption->electricity_new, $consumption->electricity_unit_price);
        $waterPrice = $this->calculateWaterPrice($consumption->water_old, $consumption->water_new, $consumption->water_unit_price);
        $occupiedUnitPrice = $this->calculateOccupiedPrice($consumption->start_occupied_date, $consumption->stop_occupied_date, $consumption->occupied_unit_price);

        return [
            'electricity_price' => $electricityPrice,
            'water_price' => $waterPrice,
            'occupied_price' => $occupiedUnitPrice,
        ];
    }

    public function calculateElectricityPrice($old, $new, $unitPrice)
    {
        return $unitPrice * ($new - $old);
    }

    public function calculateWaterPrice($old, $new, $unitPrice)
    {
        return $unitPrice * ($new - $old);
    }

    public function calculateOccupiedPrice($startDate, $stopDate, $unitPrice)
    {
        if (empty($stopDate)) {
            return 0;
        }

        $days = Carbon::parse($startDate)->diffInDays(Carbon::parse($stopDate));
        return $days * $unitPrice;
    }
}
