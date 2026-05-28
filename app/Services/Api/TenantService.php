<?php

namespace App\Services\Api;

use App\Repositories\Api\TenantRepository;
use App\Services\CustomService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TenantService extends CustomService
{
    public function __construct(
        public TenantRepository $tenantRepository
    ) {
        parent::__construct();
    }

    public function getListForSearch($dataSearch = [])
    {
        return $this->tenantRepository->getListForSearch($dataSearch);
    }

    public function store($params)
    {
        try {
            $this->tenantRepository->create($params);
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            return false;
        }

        return true;
    }

    public function getById($id)
    {
        return $this->tenantRepository->find($id);
    }

    public function update($id, $params)
    {
        try {
            $this->tenantRepository->update($id, $params);
        } catch (\Throwable $exception) {
            logError($exception->getMessage());
            return false;
        }

        return true;
    }

    public function delete($id)
    {
        try {
            $this->tenantRepository->delete($id);
        } catch (\Throwable $exception) {
            logInfo($exception->getMessage());
            return false;
        }

        return true;
    }

    public function storeAndAssign($params, $roomId)
    {
        DB::beginTransaction();
        try {
            $tenant = $this->tenantRepository->create($params);
            $tenant->roomHistories()->attach([
                $roomId => [
                    'move_in_date' => Carbon::now(),
                    'is_representative' => $params['is_representative'],
                    'note' => $params['note']
                ]
            ]);
            DB::commit();
        } catch (\Throwable $exception) {
            logInfo($exception->getMessage());
            DB::rollBack();
            return false;
        }
        return true;
    }
}
