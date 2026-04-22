<?php

namespace App\Services\Api;

use App\Repositories\Api\DebtRepository;
use App\Services\CustomService;

class DebtService extends CustomService
{
    public function __construct(
        public DebtRepository $debtRepository
    ) {
        parent::__construct();
    }

    public function getListForSearch($dataSearch = [])
    {
        return $this->debtRepository->getListForSearch($dataSearch);
    }

    public function store($params)
    {
        try {
            $this->debtRepository->create($params);
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            return false;
        }

        return true;
    }

    public function getById($id)
    {
        return $this->debtRepository->find($id);
    }

    public function update($id, $params)
    {
        try {
            $this->debtRepository->update($id, $params);
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            return false;
        }

        return true;
    }

    public function delete($id)
    {
        try {
            $this->debtRepository->delete($id);
        } catch (\Throwable $exception) {
            logInfo($exception->getMessage());
            return false;
        }

        return true;
    }
}
