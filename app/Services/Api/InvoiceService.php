<?php

namespace App\Services\Api;

use App\Repositories\Api\InvoiceRepository;
use App\Services\CustomService;

class InvoiceService extends CustomService
{
    public function __construct(
        public InvoiceRepository $invoiceRepository
    ) {
        parent::__construct();
    }

    public function getListForSearch($dataSearch = [])
    {
        return $this->invoiceRepository->getListForSearch($dataSearch);
    }

    public function store($params)
    {
        try {
            $this->invoiceRepository->create($params);
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            return false;
        }

        return true;
    }

    public function getById($id)
    {
        return $this->invoiceRepository->find($id);
    }

    public function update($id, $params)
    {
        try {
            $this->invoiceRepository->update($id, $params);
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            return false;
        }

        return true;
    }

    public function delete($id)
    {
        try {
            $this->invoiceRepository->delete($id);
        } catch (\Throwable $exception) {
            logInfo($exception->getMessage());
            return false;
        }

        return true;
    }
}
