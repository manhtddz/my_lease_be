<?php

namespace App\Services\Api;

use App\Repositories\Api\RoomRepository;
use App\Services\CustomService;

class RoomService extends CustomService
{
    public function __construct(
        public RoomRepository $roomRepository
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
}
