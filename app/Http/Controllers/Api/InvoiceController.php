<?php

namespace App\Http\Controllers\Api;

use App\Services\Api\InvoiceService;
use App\Validators\Api\Invoice\InvoiceCreateFormRequest;
use App\Validators\Api\Invoice\InvoiceUpdateFormRequest;
use App\Validators\Api\Invoice\PayRequest;
use Symfony\Component\HttpFoundation\Response;

class InvoiceController extends BaseApiController
{
    public function __construct(
        public InvoiceService $invoiceService
    ) {
        parent::__construct();
    }

    public function index()
    {
        $invoices = $this->invoiceService->getListForSearch(request()->all());
        return $this->success($invoices, __('messages.success'));
    }

    public function show($id)
    {
        $invoice = $this->invoiceService->getById($id);
        if (empty($invoice)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        return $this->success($invoice, __('messages.success'));
    }

    public function store(InvoiceCreateFormRequest $request)
    {
        $store = $this->invoiceService->store($request->validated());
        if ($store) {
            return $this->success($store, __('messages.create_success'));
        }
        return $this->error(__('messages.create_failed'));
    }

    public function update($id, InvoiceUpdateFormRequest $request)
    {
        $invoice = $this->invoiceService->getById($id);
        if (empty($invoice)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        $update = $this->invoiceService->update($id, $request->validated());
        if ($update) {
            return $this->success($update, __('messages.update_success'));
        }
        return $this->error(__('messages.update_failed'));
    }

    public function destroy($id)
    {
        $invoice = $this->invoiceService->getById($id);
        if (empty($invoice)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        if ($this->invoiceService->hasActivePayment($id)) {
            return $this->error(__('messages.invoice_has_active_payment'), Response::HTTP_BAD_REQUEST);
        }

        $delete = $this->invoiceService->delete($id);
        if ($delete) {
            return $this->success($delete, __('messages.delete_success'));
        }
        return $this->error(__('messages.delete_failed'));
    }

    public function payInvoice($id, PayRequest $request)
    {
        $invoice = $this->invoiceService->getNotPaidInvoiceById($id);
        if (empty($invoice)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        $isPaySuccess = $this->invoiceService->payInvoice($invoice, $request->validated());

        if ($isPaySuccess) {
            return $this->success($isPaySuccess, __('messages.update_success'));
        }
        return $this->error(__('messages.update_failed'));
    }
}
