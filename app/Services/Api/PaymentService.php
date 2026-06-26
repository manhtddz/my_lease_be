<?php

namespace App\Services\Api;

use App\Enums\ActiveStatusEnum;
use App\Enums\PaymentStatusEnum;
use App\Models\Payment;
use App\Repositories\Api\PaymentRepository;
use App\Services\CustomService;
use Illuminate\Support\Facades\DB;

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

    public function cancel($payment)
    {
        // Guard: tránh cancel lại payment đã bị huỷ → tránh trừ tiền 2 lần
        if ($payment->status == ActiveStatusEnum::CANCELLED) {
            return false;
        }

        DB::beginTransaction();
        try {
            $payment->update([
                'status' => ActiveStatusEnum::CANCELLED,
            ]);

            // Tính lại tổng tiền đã trả còn hiệu lực của invoice sau khi huỷ
            $totalPaid = Payment::where('invoice_id', $payment->invoice_id)
                ->where('status', ActiveStatusEnum::ACTIVE)
                ->sum('payment_amount');

            $newStatus = $totalPaid > 0
                ? PaymentStatusEnum::PARTIALLY_PAID
                : PaymentStatusEnum::INITIAL;

            $payment->invoice()->update(['payment_status' => $newStatus]);

            DB::commit();
            return true;
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            DB::rollBack();
            return false;
        }
    }
}
