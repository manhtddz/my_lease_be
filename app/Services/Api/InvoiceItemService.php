<?php

namespace App\Services\Api;

use App\Repositories\Api\InvoiceItemRepository;
use App\Services\CustomService;

class InvoiceItemService extends CustomService
{
    public function __construct(
        public InvoiceItemRepository $invoiceItemRepository
    ) {
        parent::__construct();
    }

    public function getListForSearch($dataSearch = [])
    {
        return $this->invoiceItemRepository->getListForSearch($dataSearch);
    }

    public function store($params)
    {
        try {
            $this->invoiceItemRepository->create($params);
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            return false;
        }

        return true;
    }

    public function getById($id)
    {
        return $this->invoiceItemRepository->newQuery()
            ->with(['invoice', 'debt', 'roomSidePaid'])
            ->find($id);
    }

    public function update($id, $params)
    {
        try {
            $this->invoiceItemRepository->update($id, $params);
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            return false;
        }

        return true;
    }

    public function delete($id)
    {
        try {
            $this->invoiceItemRepository->delete($id);
        } catch (\Throwable $exception) {
            logInfo($exception->getMessage());
            return false;
        }

        return true;
    }
}
