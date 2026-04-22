<?php

namespace App\Services\Api;

use App\Repositories\Api\PaymentRepository;
use App\Services\CustomService;

class PaymentService extends CustomService
{
    public function __construct(
        public PaymentRepository $paymentRepository
    ) {
        parent::__construct();
    }

    public function getListForSearch($dataSearch = [])
    {
        return $this->paymentRepository->getListForSearch($dataSearch);
    }

    public function store($params)
    {
        try {
            $this->paymentRepository->create($params);
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            return false;
        }

        return true;
    }

    public function getById($id)
    {
        return $this->paymentRepository->find($id);
    }

    public function update($id, $params)
    {
        try {
            $this->paymentRepository->update($id, $params);
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            return false;
        }

        return true;
    }

    public function delete($id)
    {
        try {
            $this->paymentRepository->delete($id);
        } catch (\Throwable $exception) {
            logInfo($exception->getMessage());
            return false;
        }

        return true;
    }
}
