<?php

namespace App\Http\Controllers\Api;

use App\Services\Api\RoomSidePaidService;
use App\Validators\Api\RoomSidePaid\RoomSidePaidCreateFormRequest;
use App\Validators\Api\RoomSidePaid\RoomSidePaidUpdateFormRequest;
use Symfony\Component\HttpFoundation\Response;

class RoomSidePaidController extends BaseApiController
{
    public function __construct(
        public RoomSidePaidService $roomSidePaidService
    ) {
        parent::__construct();
    }

    public function index()
    {
        $roomSidePaids = $this->roomSidePaidService->getListForSearch(request()->all());
        return $this->success($roomSidePaids, __('messages.success'));
    }

    public function show($id)
    {
        $roomSidePaid = $this->roomSidePaidService->getById($id);
        if (empty($roomSidePaid)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        return $this->success($roomSidePaid, __('messages.success'));
    }

    public function store(RoomSidePaidCreateFormRequest $request)
    {
        $store = $this->roomSidePaidService->store($request->validated());
        if ($store) {
            return $this->success($store, __('messages.create_success'));
        }
        return $this->error(__('messages.create_failed'));
    }

    public function update($id, RoomSidePaidUpdateFormRequest $request)
    {
        $roomSidePaid = $this->roomSidePaidService->getById($id);
        if (empty($roomSidePaid)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        $update = $this->roomSidePaidService->update($id, $request->validated());
        if ($update) {
            return $this->success($update, __('messages.update_success'));
        }
        return $this->error(__('messages.update_failed'));
    }

    public function destroy($id)
    {
        $roomSidePaid = $this->roomSidePaidService->getById($id);
        if (empty($roomSidePaid)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        $delete = $this->roomSidePaidService->delete($id);
        if ($delete) {
            return $this->success($delete, __('messages.delete_success'));
        }
        return $this->error(__('messages.delete_failed'));
    }
}
