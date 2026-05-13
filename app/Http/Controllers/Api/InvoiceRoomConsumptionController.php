<?php

namespace App\Http\Controllers\Api;

use App\Services\Api\InvoiceRoomConsumptionService;
use App\Validators\Api\InvoiceRoomConsumption\InvoiceRoomConsumptionCreateFormRequest;
use App\Validators\Api\InvoiceRoomConsumption\InvoiceRoomConsumptionUpdateFormRequest;
use Symfony\Component\HttpFoundation\Response;

class InvoiceRoomConsumptionController extends BaseApiController
{
    public function __construct(
        public InvoiceRoomConsumptionService $invoiceRoomConsumptionService
    ) {
        parent::__construct();
    }

    public function index()
    {
        $rows = $this->invoiceRoomConsumptionService->getListForSearch(request()->all());
        return $this->success($rows, __('messages.success'));
    }

    public function show($id)
    {
        $row = $this->invoiceRoomConsumptionService->getById($id);
        if (empty($row)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        return $this->success($row, __('messages.success'));
    }

    public function store(InvoiceRoomConsumptionCreateFormRequest $request)
    {
        $store = $this->invoiceRoomConsumptionService->store($request->validated());
        if ($store) {
            return $this->success($store, __('messages.create_success'));
        }
        return $this->error(__('messages.create_failed'));
    }

    public function update($id, InvoiceRoomConsumptionUpdateFormRequest $request)
    {
        $row = $this->invoiceRoomConsumptionService->getById($id);
        if (empty($row)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        $update = $this->invoiceRoomConsumptionService->update($id, $request->validated());
        if ($update) {
            return $this->success($update, __('messages.update_success'));
        }
        return $this->error(__('messages.update_failed'));
    }

    public function destroy($id)
    {
        $row = $this->invoiceRoomConsumptionService->getById($id);
        if (empty($row)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        $delete = $this->invoiceRoomConsumptionService->delete($id);
        if ($delete) {
            return $this->success($delete, __('messages.delete_success'));
        }
        return $this->error(__('messages.delete_failed'));
    }
}
