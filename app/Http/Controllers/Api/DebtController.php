<?php

namespace App\Http\Controllers\Api;

use App\Services\Api\DebtService;
use App\Validators\Api\Debt\DebtCreateFormRequest;
use App\Validators\Api\Debt\DebtUpdateFormRequest;
use Symfony\Component\HttpFoundation\Response;

class DebtController extends BaseApiController
{
    public function __construct(
        public DebtService $debtService
    ) {
        parent::__construct();
    }

    public function index()
    {
        $debts = $this->debtService->getListForSearch(request()->all());
        return $this->success($debts, __('messages.success'));
    }

    public function show($id)
    {
        $debt = $this->debtService->getById($id);
        if (empty($debt)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        return $this->success($debt, __('messages.success'));
    }

    public function store(DebtCreateFormRequest $request)
    {
        $store = $this->debtService->store($request->validated());
        if ($store) {
            return $this->success($store, __('messages.create_success'));
        }
        return $this->error(__('messages.create_failed'));
    }

    public function update($id, DebtUpdateFormRequest $request)
    {
        $debt = $this->debtService->getById($id);
        if (empty($debt)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        $update = $this->debtService->update($id, $request->validated());
        if ($update) {
            return $this->success($update, __('messages.update_success'));
        }
        return $this->error(__('messages.update_failed'));
    }

    public function destroy($id)
    {
        $debt = $this->debtService->getById($id);
        if (empty($debt)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        $delete = $this->debtService->delete($id);
        if ($delete) {
            return $this->success($delete, __('messages.delete_success'));
        }
        return $this->error(__('messages.delete_failed'));
    }
}
