<?php

namespace App\Services\Api;

use App\Enums\ActiveStatusEnum;
use App\Enums\DebtTypeEnum;
use App\Enums\PaymentStatusEnum;
use App\Models\Invoice;
use App\Repositories\Api\DebtRepository;
use App\Repositories\Api\PaymentRepository;
use App\Services\CustomService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DebtService extends CustomService
{
    public function __construct(
        public DebtRepository $debtRepository,
        public InvoiceService $invoiceService,
        public PaymentRepository $paymentRepository,
    ) {
        parent::__construct();
    }

    /**
     * Batch entry point: find invoices whose payment is overdue (created more
     * than one month ago and not fully paid), flag them as NOT_PAID_OVERDUE and
     * create a Debt record for the outstanding amount of each one.
     *
     * @return array{total:int, processed:int, skipped:int}
     */
    public function executeOverdueInvoices(): array
    {
        $overdueBefore = now()->subMonth();
        $invoices = $this->invoiceService->getOverdueUnpaidInvoices($overdueBefore);

        $processed = 0;
        $skipped = 0;

        foreach ($invoices as $invoice) {
            $this->convertInvoiceToOverdueDebt($invoice) ? $processed++ : $skipped++;
        }

        return [
            'total'     => $invoices->count(),
            'processed' => $processed,
            'skipped'   => $skipped,
        ];
    }

    /**
     * Flag a single overdue invoice and create its Debt record atomically.
     * Returns false (and leaves the invoice untouched) when it cannot be
     * processed safely, so the next run can retry it.
     */
    protected function convertInvoiceToOverdueDebt(Invoice $invoice): bool
    {
        $totalAmount = $invoice->invoiceItems()->sum('amount');
        $paidAmount = $invoice->payments()
            ->where('status', ActiveStatusEnum::ACTIVE)
            ->sum('payment_amount');
        $remainingAmount = $totalAmount - $paidAmount;

        // Status says unpaid but nothing is actually outstanding — skip to avoid a zero/negative debt.
        if ($remainingAmount <= 0) {
            logInfo("Overdue batch: invoice #{$invoice->id} has no outstanding amount, skipped.");
            return false;
        }

        // Payment deadline that was missed — also the boundary for the tenant lookup below.
        // created_at isn't cast to Carbon on this model, so parse it explicitly.
        $dueDate = Carbon::parse($invoice->created_at)->addMonth();

        DB::beginTransaction();
        try {
            $this->debtRepository->create([
                'invoice_id'       => $invoice->id,
                'original_amount'  => $remainingAmount,
                'paid_amount'      => 0,
                'remaining_amount' => $remainingAmount,
                'penalty_amount'   => 0,
                'debt_type'        => DebtTypeEnum::TENANT,
                'due_date'         => $dueDate,
                'status'           => ActiveStatusEnum::ACTIVE,
                'note'             => "Auto-generated from overdue invoice #{$invoice->id}",
            ]);

            // Call the repository directly (not invoiceService->update, which swallows
            // exceptions) so any failure propagates and rolls the transaction back.
            $this->invoiceService->invoiceRepository->update($invoice->id, [
                'payment_status' => PaymentStatusEnum::NOT_PAID_OVERDUE,
            ]);
        } catch (\Throwable $exception) {
            DB::rollBack();
            logError("Overdue batch: failed to process invoice #{$invoice->id}: " . $exception->getMessage());
            return false;
        }

        DB::commit();
        return true;
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
        return $this->debtRepository->newQuery()
            ->with(['invoiceItems', 'invoice', 'tenant'])
            ->find($id);
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

    public function payDebt($debt, $params)
    {
        $remainingAmount = $debt->remaining_amount;
        $paidAmount = $debt->paid_amount;
        if ($remainingAmount < $params['payment_amount']) {
            throw ValidationException::withMessages(['payment_amount' => [__('messages.this_payment_is_exceeded')]]);
        }

        DB::beginTransaction();
        try {
            $this->paymentRepository->create([
                'payment_amount' => $params['payment_amount'],
                'debt_id' => $debt->id,
                'payment_date' => now(),
                'payment_method' => $params['payment_method'],
                'tenant_id' => $params['tenant_id'],
                'status' => ActiveStatusEnum::ACTIVE,
                'note' => $params['note'],
            ]);

            $this->debtRepository->update($debt->id, [
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
