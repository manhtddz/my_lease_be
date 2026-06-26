<?php

namespace App\Services\Api;

use App\Enums\ActiveStatusEnum;
use App\Enums\IsPresentativeEnum;
use App\Enums\ItemTypeEnum;
use App\Enums\PaymentStatusEnum;
use App\Models\Invoice;
use App\Models\Payment;
use App\Models\TenantRoomHistory;
use App\Repositories\Api\InvoiceItemRepository;
use App\Repositories\Api\InvoiceRepository;
use App\Repositories\Api\PaymentRepository;
use App\Services\CustomService;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class InvoiceService extends CustomService
{
    public function __construct(
        public InvoiceRepository $invoiceRepository,
        public InvoiceItemRepository $invoiceItemRepository,
        public PaymentRepository $paymentRepository,
        public RoomConsumptionService $roomConsumptionService,
        public RoomService $roomService,
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
        $isValidRepresentTenant = $this->roomService->checkTenantIsRepresentOfRoom($params['representative_tenant_id'], $roomId);
        if (!$isValidConsumptions) {
            throw ValidationException::withMessages(['room_consumption_ids' => [__('messages.consumption_not_from_expected_room')]]);
        }

        if (!$isValidRepresentTenant) {
            throw ValidationException::withMessages(['representative_tenant_id' => [__('messages.tenant_not_accepted')]]);
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

    public function getOverdueUnpaidInvoices($overdueBefore)
    {
        return $this->invoiceRepository->getOverdueUnpaidInvoices($overdueBefore);
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

    public function hasActivePayment($id)
    {
        return Payment::where('invoice_id', $id)
            ->where('status', ActiveStatusEnum::ACTIVE)
            ->exists();
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
        
        $paidAmount = $invoice->payments()
            ->where('status', ActiveStatusEnum::ACTIVE)
            ->sum('payment_amount');

        if ($totalAmount == $paidAmount) {
            return false;
        }

        $newTotalPaid = $paidAmount + $paymentAmount;   
        if ($newTotalPaid > $totalAmount) {
            throw ValidationException::withMessages(['payment_amount' => [__('messages.this_payment_is_exceeded')]]);
        }
       
        DB::beginTransaction();
        try {
            $this->paymentRepository->create([
                'invoice_id'     => $invoice->id,
                'tenant_id'      => $tenantId,
                'payment_amount' => $paymentAmount,
                'payment_date'   => $params['payment_date'],
                'payment_method' => $params['payment_method'],
                'status'         => ActiveStatusEnum::ACTIVE,
            ]);

            $newStatus = $newTotalPaid >= $totalAmount
                ? PaymentStatusEnum::PAID
                : PaymentStatusEnum::PARTIALLY_PAID;
            
            $this->invoiceRepository->update($invoice->id, ['payment_status' => $newStatus]);
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            DB::rollBack();
            return false;
        }

        DB::commit();
        return true;
    }

    public function getInvoiceByConsumption($roomConsumption)
    {
        $invoice = $roomConsumption->invoices()
            ->with(['invoiceItems'])
            ->first();
        return $invoice;
    }
}
