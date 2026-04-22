<?php

namespace App\Services\Api;

use App\Repositories\Api\TenantRoomHistoryRepository;
use App\Services\CustomService;

class TenantRoomHistoryService extends CustomService
{
    public function __construct(
        public TenantRoomHistoryRepository $tenantRoomHistoryRepository
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
}
