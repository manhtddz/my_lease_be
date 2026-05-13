<?php

namespace App\Http\Controllers\Api;

use App\Services\Api\InvoiceItemService;
use App\Validators\Api\InvoiceItem\InvoiceItemCreateFormRequest;
use App\Validators\Api\InvoiceItem\InvoiceItemUpdateFormRequest;
use Symfony\Component\HttpFoundation\Response;

class InvoiceItemController extends BaseApiController
{
    public function __construct(
        public InvoiceItemService $invoiceItemService
    ) {
        parent::__construct();
    }

    public function index()
    {
        $rows = $this->invoiceItemService->getListForSearch(request()->all());
        return $this->success($rows, __('messages.success'));
    }

    public function show($id)
    {
        $row = $this->invoiceItemService->getById($id);
        if (empty($row)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        return $this->success($row, __('messages.success'));
    }

    public function store(InvoiceItemCreateFormRequest $request)
    {
        $store = $this->invoiceItemService->store($request->validated());
        if ($store) {
            return $this->success($store, __('messages.create_success'));
        }
        return $this->error(__('messages.create_failed'));
    }

    public function update($id, InvoiceItemUpdateFormRequest $request)
    {
        $row = $this->invoiceItemService->getById($id);
        if (empty($row)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        $update = $this->invoiceItemService->update($id, $request->validated());
        if ($update) {
            return $this->success($update, __('messages.update_success'));
        }
        return $this->error(__('messages.update_failed'));
    }

    public function destroy($id)
    {
        $row = $this->invoiceItemService->getById($id);
        if (empty($row)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        $delete = $this->invoiceItemService->delete($id);
        if ($delete) {
            return $this->success($delete, __('messages.delete_success'));
        }
        return $this->error(__('messages.delete_failed'));
    }
}
