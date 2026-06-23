<?php

namespace App\Services\Api;

use App\Enums\ActiveStatusEnum;
use App\Enums\DebtTypeEnum;
use App\Enums\IsPresentativeEnum;
use App\Enums\ItemTypeEnum;
use App\Enums\PaymentStatusEnum;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\TenantRoomHistory;
use App\Repositories\Api\DebtRepository;
use App\Repositories\Api\InvoiceItemRepository;
use App\Repositories\Api\InvoiceRepository;
use App\Repositories\Api\PaymentRepository;
use App\Services\CustomService;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InvoiceService extends CustomService
{
    public function __construct(
        public InvoiceRepository $invoiceRepository,
        public InvoiceItemRepository $invoiceItemRepository,
        public PaymentRepository $paymentRepository,
        public DebtRepository $debtRepository,
        public RoomConsumptionService $roomConsumptionService,
    ) {
        parent::__construct();
    }

    public function getListForSearch($dataSearch = [])
    {
        return $this->invoiceRepository->getListForSearch($dataSearch);
    }

    public function store($params)
    {
        $consumptionList = $params['room_consumption_ids'];
        $roomId = $params['room_id'];
        $isValidConsumptions = $this->roomConsumptionService->checkConsumptionBelongsToRoom($consumptionList, $roomId);

        if (!$isValidConsumptions) {
            throw ValidationException::withMessages(['room_consumption_ids' => [__('messages.consumption_not_from_expected_room')]]);
        }

        DB::beginTransaction();
        try {
            $createdInvoice = $this->invoiceRepository->create($params);
            foreach ($consumptionList as $consumptionId) {
                $consumption = $this->roomConsumptionService->getById($consumptionId);

                $amountData = $this->roomConsumptionService->calculateAllConsumptionPrice($consumption);

                $this->invoiceItemRepository->insertMany([
                    [
                        'invoice_id' => $createdInvoice->id,
                        'room_consumption_id' => $consumptionId,
                        'amount' => $amountData['electricity_price'],
                        'item_type' => ItemTypeEnum::ELECTRICITY,
                        'item_name' => ItemTypeEnum::texts()[ItemTypeEnum::ELECTRICITY] . "_{$consumptionId}",
                    ],
                    [
                        'invoice_id' => $createdInvoice->id,
                        'room_consumption_id' => $consumptionId,
                        'amount' => $amountData['water_price'],
                        'item_type' => ItemTypeEnum::WATER,
                        'item_name' => ItemTypeEnum::texts()[ItemTypeEnum::WATER] . "_{$consumptionId}",
                    ],
                    [
                        'invoice_id' => $createdInvoice->id,
                        'room_consumption_id' => $consumptionId,
                        'amount' => $amountData['occupied_price'],
                        'item_type' => ItemTypeEnum::OCCUPIED,
                        'item_name' => ItemTypeEnum::texts()[ItemTypeEnum::OCCUPIED] . "_{$consumptionId}",
                    ],
                ]);
            }
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            DB::rollBack();
            return false;
        }

        DB::commit();
        return true;
    }

    public function getById($id)
    {
        return $this->invoiceRepository->findForShow($id);
    }

    public function getNotPaidInvoiceById($id)
    {
        return $this->invoiceRepository->getNotPaidInvoiceById($id);
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

    public function payInvoice(Invoice $invoice, $params)
    {
        $tenantHistory = TenantRoomHistory::where('room_id', $invoice->room_id)
            ->where('is_representative', IsPresentativeEnum::TRUE)
            ->where(function ($q) {
                $q->whereNull('move_out_date')
                    ->orWhere('move_out_date', '>', now());
            })
            ->first();

        if (empty($tenantHistory)) {
            throw ValidationException::withMessages(['invoice' => [__('messages.no_representative_tenant')]]);
        }

        $tenantId = $tenantHistory->tenant_id;
        $paymentAmount = $params['payment_amount'];
        $totalAmount = $invoice->invoiceItems()
            ->sum('amount');
        
        $debt = $invoice->debt()->first();
        $paidAmount = $debt?->paid_amount ?? 0;
        $newTotalPaid = $paidAmount + $paymentAmount;            
        DB::beginTransaction();
        try {
            $this->paymentRepository->create([
                'invoice_id'     => $invoice->id,
                'tenant_id'      => $tenantId,
                'payment_amount' => $paymentAmount,
                'payment_date'   => $params['payment_date'],
                'payment_method' => $params['payment_method'],
                'payment_status' => ActiveStatusEnum::ACTIVE,
            ]);

            $newStatus = $newTotalPaid >= $totalAmount
                ? PaymentStatusEnum::PAID
                : PaymentStatusEnum::PARTIALLY_PAID;

            $this->invoiceRepository->update($invoice->id, ['payment_status' => $newStatus]);

            if ($newStatus === PaymentStatusEnum::PAID && $debt) {
                $this->debtRepository->update($debt->id, [
                    'paid_amount'      => $newTotalPaid,
                    'remaining_amount' => 0,
                    'debt_type'        => DebtTypeEnum::TENANT,
                    'status'           => ActiveStatusEnum::ACTIVE,
                ]);
            }
    
            if ($newStatus === PaymentStatusEnum::PARTIALLY_PAID) {
                $remainingAmount = $totalAmount - $newTotalPaid;
                if ($debt) {
                    $this->debtRepository->update($debt->id, [
                        'paid_amount'      => $newTotalPaid,
                        'remaining_amount' => $remainingAmount,
                        'debt_type'        => DebtTypeEnum::TENANT,
                        'status'           => ActiveStatusEnum::ACTIVE,
                    ]);
                } else {
                    $this->debtRepository->create([
                        'invoice_id'       => $invoice->id,
                        'tenant_id'        => $tenantId,
                        'original_amount'  => $totalAmount,
                        'paid_amount'      => $newTotalPaid,
                        'remaining_amount' => $remainingAmount,
                        'debt_type'        => DebtTypeEnum::TENANT,
                        'status'           => ActiveStatusEnum::ACTIVE,
                    ]);
                }
            }
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            DB::rollBack();
            return false;
        }

        DB::commit();
        return true;
    }
}
