<?php

namespace App\Services\Api;

use App\Enums\ActiveStatusEnum;
use App\Repositories\Api\PaymentRepository;
use App\Repositories\Api\RenovationRepository;
use App\Services\CustomService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RenovationService extends CustomService
{
    public function __construct(
        public RenovationRepository $renovationRepository,
        public PaymentRepository $paymentRepository,
    ) {
        parent::__construct();
    }

    public function getListForSearch($dataSearch = [])
    {
        return $this->renovationRepository->getListForSearch($dataSearch);
    }

    public function store($params)
    {
        try {
            $this->renovationRepository->create($params);
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            return false;
        }

        return true;
    }

    public function getById($id)
    {
        return $this->renovationRepository->newQuery()
            ->with(['invoiceItems', 'room', 'tenant'])
            ->find($id);
    }

    public function update($id, $params)
    {
        try {
            $this->renovationRepository->update($id, $params);
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            return false;
        }

        return true;
    }

    public function delete($id)
    {
        try {
            $this->renovationRepository->delete($id);
        } catch (\Throwable $exception) {
            logInfo($exception->getMessage());
            return false;
        }

        return true;
    }

    public function payRenovation($renovation, $params)
    {
        $remainingAmount = $renovation->amount;
        $paidAmount = $renovation->paid_amount;
        if ($remainingAmount < $params['payment_amount']) {
            throw ValidationException::withMessages(['payment_amount' => [__('messages.this_payment_is_exceeded')]]);
        }

        DB::beginTransaction();
        try {
            $this->paymentRepository->create([
                'payment_amount' => $params['payment_amount'],
                'renovation_id' => $renovation->id,
                'payment_date' => now(),
                'payment_method' => $params['payment_method'],
                'tenant_id' => $params['tenant_id'],
                'status' => ActiveStatusEnum::ACTIVE,
                'note' => $params['note'],
            ]);

            $this->renovationRepository->update($renovation->id, [
                'remaining_amount' => $remainingAmount - $params['payment_amount'],
                'paid_amount' => $paidAmount + $params['payment_amount'],
                'tenant_id' => $params['tenant_id'],
            ]);

        } catch (\Throwable $exception) {
            DB::rollBack();
            logInfo($exception->getMessage());
            return false;
        }

        DB::commit();
        return true;
    }
}
