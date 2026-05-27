<?php

namespace App\Http\Controllers\Api;

use App\Services\Api\RoomService;
use App\Services\Api\TenantService;
use App\Validators\Api\Tenant\TenantCreateAndAssignFormRequest;
use App\Validators\Api\Tenant\TenantCreateFormRequest;
use App\Validators\Api\Tenant\TenantUpdateFormRequest;
use Symfony\Component\HttpFoundation\Response;

class TenantController extends BaseApiController
{
    public function __construct(
        public TenantService $tenantService,
        public RoomService $roomService,
    ) {
        parent::__construct();
    }

    public function index()
    {
        $tenants = $this->tenantService->getListForSearch(request()->all());

        return $this->success($tenants, __('messages.success'));
    }

    public function show($id)
    {
        $tenant = $this->tenantService->getById($id);
        if (empty($tenant)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        return $this->success($tenant, __('messages.success'));
    }

    public function store(TenantCreateFormRequest $request)
    {
        $store = $this->tenantService->store($request->validated());
        if ($store) {
            return $this->success($store, __('messages.create_success'));
        }

        return $this->error(__('messages.create_failed'));
    }

    public function update($id, TenantUpdateFormRequest $request)
    {
        $tenant = $this->tenantService->getById($id);
        if (empty($tenant)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        $update = $this->tenantService->update($id, $request->validated());
        if ($update) {
            return $this->success($update, __('messages.update_success'));
        }

        return $this->error(__('messages.update_failed'));
    }

    public function destroy($id)
    {
        $tenant = $this->tenantService->getById($id);
        if (empty($tenant)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        $delete = $this->tenantService->delete($id);
        if ($delete) {
            return $this->success($delete, __('messages.delete_success'));
        }

        return $this->error(__('messages.delete_failed'));
    }

    public function storeAndAssign(TenantCreateAndAssignFormRequest $request)
    {
        $params = $request->validated();
        $roomId = $params['room_id'];
        $room = $this->roomService->getById($roomId);

        if (empty($room)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        $create = $this->tenantService->storeAndAssign($params, $roomId);

        if ($create) {
            return $this->success($create, __('messages.create_success'));
        }

        return $this->error(__('messages.create_failed'));
    }
}
