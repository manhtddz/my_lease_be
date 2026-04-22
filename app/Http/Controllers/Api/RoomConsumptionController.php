<?php

namespace App\Http\Controllers\Api;

use App\Services\Api\RoomConsumptionService;
use App\Validators\Api\RoomConsumption\RoomConsumptionCreateFormRequest;
use App\Validators\Api\RoomConsumption\RoomConsumptionUpdateFormRequest;
use Symfony\Component\HttpFoundation\Response;

class RoomConsumptionController extends BaseApiController
{
    public function __construct(
        public RoomConsumptionService $roomConsumptionService
    ) {
        parent::__construct();
    }

    public function index()
    {
        $roomConsumptions = $this->roomConsumptionService->getListForSearch(request()->all());
        return $this->success($roomConsumptions, __('messages.success'));
    }

    public function show($id)
    {
        $roomConsumption = $this->roomConsumptionService->getById($id);
        if (empty($roomConsumption)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        return $this->success($roomConsumption, __('messages.success'));
    }

    public function store(RoomConsumptionCreateFormRequest $request)
    {
        $store = $this->roomConsumptionService->store($request->validated());
        if ($store) {
            return $this->success($store, __('messages.create_success'));
        }
        return $this->error(__('messages.create_failed'));
    }

    public function update($id, RoomConsumptionUpdateFormRequest $request)
    {
        $roomConsumption = $this->roomConsumptionService->getById($id);
        if (empty($roomConsumption)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        $update = $this->roomConsumptionService->update($id, $request->validated());
        if ($update) {
            return $this->success($update, __('messages.update_success'));
        }
        return $this->error(__('messages.update_failed'));
    }

    public function destroy($id)
    {
        $roomConsumption = $this->roomConsumptionService->getById($id);
        if (empty($roomConsumption)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        $delete = $this->roomConsumptionService->delete($id);
        if ($delete) {
            return $this->success($delete, __('messages.delete_success'));
        }
        return $this->error(__('messages.delete_failed'));
    }
}
