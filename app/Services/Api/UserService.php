<?php

namespace App\Services\Api;

use App\Services\CustomService;
use App\Repositories\Api\UserRepository;

class UserService extends CustomService
{
    public function __construct(
        public UserRepository $userRepository
    ) {
        parent::__construct();
    }

    public function getListForSearch($dataSearch = [])
    {
        return $this->userRepository->getListForSearch($dataSearch);
    }

    public function store($params)
    {
        try {
            $this->userRepository->create($params);
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            return false;
        }

        return true;
    }

    public function getById($id)
    {
        return $this->userRepository->getById($id);
    }

    public function update($id, $params)
    {
        try {
            $this->userRepository->update($id, $params);
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            return false;
        }

        return true;
    }

    public function delete($id)
    {
        try {
            $this->userRepository->delete($id);
        } catch (\Throwable $exception) {
            logInfo($exception->getMessage());
            return false;
        }

        return true;
    }
}
