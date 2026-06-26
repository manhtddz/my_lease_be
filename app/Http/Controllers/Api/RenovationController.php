<?php

namespace App\Http\Controllers\Api;

use App\Services\Api\RenovationService;
use App\Validators\Api\RoomConsumption\PayRenovationFormRequest;
use App\Validators\Api\Renovation\RenovationCreateFormRequest;
use App\Validators\Api\Renovation\RenovationUpdateFormRequest;
use Symfony\Component\HttpFoundation\Response;

class RenovationController extends BaseApiController
{
    public function __construct(
        public RenovationService $renovationService
    ) {
        parent::__construct();
    }

    public function index()
    {
        $renovations = $this->renovationService->getListForSearch(request()->all());
        return $this->success($renovations, __('messages.success'));
    }

    public function show($id)
    {
        $renovation = $this->renovationService->getById($id);
        if (empty($renovation)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        return $this->success($renovation, __('messages.success'));
    }

    public function store(RenovationCreateFormRequest $request)
    {
        $store = $this->renovationService->store($request->validated());
        if ($store) {
            return $this->success($store, __('messages.create_success'));
        }
        return $this->error(__('messages.create_failed'));
    }

    public function update($id, RenovationUpdateFormRequest $request)
    {
        $renovation = $this->renovationService->getById($id);
        if (empty($renovation)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        $update = $this->renovationService->update($id, $request->validated());
        if ($update) {
            return $this->success($update, __('messages.update_success'));
        }
        return $this->error(__('messages.update_failed'));
    }

    public function destroy($id)
    {
        $renovation = $this->renovationService->getById($id);
        if (empty($renovation)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        $delete = $this->renovationService->delete($id);
        if ($delete) {
            return $this->success($delete, __('messages.delete_success'));
        }
        return $this->error(__('messages.delete_failed'));
    }

    public function payRenovation($id, PayRenovationFormRequest $request)
    {
        $renovation = $this->renovationService->getById($id);

        if ($renovation->remaining_amount == 0) {
            return $this->error(__('messages.renovation_already_paid'), Response::HTTP_BAD_REQUEST);
        }

        if (empty($renovation)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        $success = $this->renovationService->payRenovation($renovation, $request->validated());
        if ($success) {
            return $this->success($success, __('messages.delete_success'));
        }
        return $this->error(__('messages.delete_failed'));
    }
}
