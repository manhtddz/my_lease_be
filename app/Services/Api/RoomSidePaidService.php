<?php

namespace App\Services\Api;

use App\Repositories\Api\RoomSidePaidRepository;
use App\Services\CustomService;

class RoomSidePaidService extends CustomService
{
    public function __construct(
        public RoomSidePaidRepository $roomSidePaidRepository
    ) {
        parent::__construct();
    }

    public function getListForSearch($dataSearch = [])
    {
        return $this->roomSidePaidRepository->getListForSearch($dataSearch);
    }

    public function store($params)
    {
        try {
            $this->roomSidePaidRepository->create($params);
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            return false;
        }

        return true;
    }

    public function getById($id)
    {
        return $this->roomSidePaidRepository->find($id);
    }

    public function update($id, $params)
    {
        try {
            $this->roomSidePaidRepository->update($id, $params);
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            return false;
        }

        return true;
    }

    public function delete($id)
    {
        try {
            $this->roomSidePaidRepository->delete($id);
        } catch (\Throwable $exception) {
            logInfo($exception->getMessage());
            return false;
        }

        return true;
    }
}
