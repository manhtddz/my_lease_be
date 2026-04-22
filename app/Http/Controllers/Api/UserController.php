<?php

namespace App\Http\Controllers\Api;

use App\Enums\UserRoleEnum;
use App\Http\Controllers\Api\BaseApiController;
use App\Services\Api\UserService;
use App\Validators\Api\User\UserCreateFormRequest;
use App\Validators\Api\User\UserUpdateFormRequest;
use Symfony\Component\HttpFoundation\Response;

class UserController extends BaseApiController
{

    public function __construct(
        public UserService $userService
    ) {
        parent::__construct();
    }

    public function index()
    {
        $params = request()->all();

        $users = $this->userService->getListForSearch($params);

        return $this->success($users, __('messages.success'));
    }

    public function show($id)
    {
        $user = $this->userService->getById($id);

        if (empty($user)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        return $this->success($user, __('messages.success'));
    }

    public function store(UserCreateFormRequest $request)
    {
        $params = $request->validated();

        $store = $this->userService->store($params);

        if ($store) {
            return $this->success($store, __('messages.create_success'));
        }

        return $this->error(__('messages.create_failed'));
    }

    public function update($id, UserUpdateFormRequest $request)
    {
        $user = $this->userService->getById($id);

        if (empty($user)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        $params = $request->validated();

        $update = $this->userService->update($id, $params);

        if ($update) {
            return $this->success($update, __('messages.update_success'));
        }

        return $this->error(__('messages.update_failed'));
    }

    public function destroy($id)
    {
        $user = $this->userService->getById($id);

        if (empty($user)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        $delete = $this->userService->delete($id);

        if ($delete) {
            return $this->success($delete, __('messages.delete_success'));
        }

        return $this->error(__('messages.delete_failed'));
    }

    public function upToAdmin($id)
    {
        $user = $this->userService->getById($id);

        if (empty($user)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        $params = ['role' => UserRoleEnum::ADMIN];

        $update = $this->userService->update($id, $params);

        if ($update) {
            return $this->success($update, __('messages.update_success'));
        }

        return $this->error(__('messages.update_failed'));
    }
}
