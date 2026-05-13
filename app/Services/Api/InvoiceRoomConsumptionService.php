<?php

namespace App\Services\Api;

use App\Repositories\Api\InvoiceRoomConsumptionRepository;
use App\Services\CustomService;

class InvoiceRoomConsumptionService extends CustomService
{
    public function __construct(
        public InvoiceRoomConsumptionRepository $invoiceRoomConsumptionRepository
    ) {
        parent::__construct();
    }

    public function getListForSearch($dataSearch = [])
    {
        return $this->invoiceRoomConsumptionRepository->getListForSearch($dataSearch);
    }

    public function store($params)
    {
        try {
            $this->invoiceRoomConsumptionRepository->create($params);
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            return false;
        }

        return true;
    }

    public function getById($id)
    {
        return $this->invoiceRoomConsumptionRepository->newQuery()
            ->with(['invoice', 'roomConsumption'])
            ->find($id);
    }

    public function update($id, $params)
    {
        try {
            $this->invoiceRoomConsumptionRepository->update($id, $params);
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            return false;
        }

        return true;
    }

    public function delete($id)
    {
        try {
            $this->invoiceRoomConsumptionRepository->delete($id);
        } catch (\Throwable $exception) {
            logInfo($exception->getMessage());
            return false;
        }

        return true;
    }
}
