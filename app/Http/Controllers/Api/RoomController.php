<?php

namespace App\Http\Controllers\Api;

use App\Services\Api\RoomService;
use App\Validators\Api\Room\RoomCreateFormRequest;
use App\Validators\Api\Room\RoomUpdateFormRequest;
use Symfony\Component\HttpFoundation\Response;

class RoomController extends BaseApiController
{
    public function __construct(
        public RoomService $roomService
    ) {
        parent::__construct();
    }

    public function index()
    {
        $rooms = $this->roomService->getListForSearch(request()->all());

        return $this->success($rooms, __('messages.success'));
    }

    public function show($id)
    {
        $room = $this->roomService->getById($id);
        if (empty($room)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        return $this->success($room, __('messages.success'));
    }

    public function store(RoomCreateFormRequest $request)
    {
        $store = $this->roomService->store($request->validated());
        if ($store) {
            return $this->success($store, __('messages.create_success'));
        }

        return $this->error(__('messages.create_failed'));
    }

    public function update($id, RoomUpdateFormRequest $request)
    {
        $room = $this->roomService->getById($id);
        if (empty($room)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        $update = $this->roomService->update($id, $request->validated());
        if ($update) {
            return $this->success($update, __('messages.update_success'));
        }

        return $this->error(__('messages.update_failed'));
    }

    public function destroy($id)
    {
        $room = $this->roomService->getById($id);
        if (empty($room)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        $delete = $this->roomService->delete($id);
        if ($delete) {
            return $this->success($delete, __('messages.delete_success'));
        }

        return $this->error(__('messages.delete_failed'));
    }
}
