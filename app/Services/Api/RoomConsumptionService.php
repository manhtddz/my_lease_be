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
}
