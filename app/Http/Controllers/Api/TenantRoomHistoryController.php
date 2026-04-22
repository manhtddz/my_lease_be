<?php

namespace App\Http\Controllers\Api;

use App\Services\Api\TenantRoomHistoryService;
use App\Validators\Api\TenantRoomHistory\TenantRoomHistoryCreateFormRequest;
use App\Validators\Api\TenantRoomHistory\TenantRoomHistoryUpdateFormRequest;
use Symfony\Component\HttpFoundation\Response;

class TenantRoomHistoryController extends BaseApiController
{
    public function __construct(
        public TenantRoomHistoryService $tenantRoomHistoryService
    ) {
        parent::__construct();
    }

    public function index()
    {
        $histories = $this->tenantRoomHistoryService->getListForSearch(request()->all());

        return $this->success($histories, __('messages.success'));
    }

    public function show($id)
    {
        $history = $this->tenantRoomHistoryService->getById($id);
        if (empty($history)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        return $this->success($history, __('messages.success'));
    }

    public function store(TenantRoomHistoryCreateFormRequest $request)
    {
        $store = $this->tenantRoomHistoryService->store($request->validated());
        if ($store) {
            return $this->success($store, __('messages.create_success'));
        }

        return $this->error(__('messages.create_failed'));
    }

    public function update($id, TenantRoomHistoryUpdateFormRequest $request)
    {
        $history = $this->tenantRoomHistoryService->getById($id);
        if (empty($history)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        $update = $this->tenantRoomHistoryService->update($id, $request->validated());
        if ($update) {
            return $this->success($update, __('messages.update_success'));
        }

        return $this->error(__('messages.update_failed'));
    }

    public function destroy($id)
    {
        $history = $this->tenantRoomHistoryService->getById($id);
        if (empty($history)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        $delete = $this->tenantRoomHistoryService->delete($id);
        if ($delete) {
            return $this->success($delete, __('messages.delete_success'));
        }

        return $this->error(__('messages.delete_failed'));
    }
}
