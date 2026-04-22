<?php

namespace App\Http\Controllers\Api;

use App\Services\Api\PaymentService;
use App\Validators\Api\Payment\PaymentCreateFormRequest;
use App\Validators\Api\Payment\PaymentUpdateFormRequest;
use Symfony\Component\HttpFoundation\Response;

class PaymentController extends BaseApiController
{
    public function __construct(
        public PaymentService $paymentService
    ) {
        parent::__construct();
    }

    public function index()
    {
        $payments = $this->paymentService->getListForSearch(request()->all());
        return $this->success($payments, __('messages.success'));
    }

    public function show($id)
    {
        $payment = $this->paymentService->getById($id);
        if (empty($payment)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        return $this->success($payment, __('messages.success'));
    }

    public function store(PaymentCreateFormRequest $request)
    {
        $store = $this->paymentService->store($request->validated());
        if ($store) {
            return $this->success($store, __('messages.create_success'));
        }
        return $this->error(__('messages.create_failed'));
    }

    public function update($id, PaymentUpdateFormRequest $request)
    {
        $payment = $this->paymentService->getById($id);
        if (empty($payment)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        $update = $this->paymentService->update($id, $request->validated());
        if ($update) {
            return $this->success($update, __('messages.update_success'));
        }
        return $this->error(__('messages.update_failed'));
    }

    public function destroy($id)
    {
        $payment = $this->paymentService->getById($id);
        if (empty($payment)) {
            return $this->error(__('messages.no_data'), Response::HTTP_NOT_FOUND);
        }

        $delete = $this->paymentService->delete($id);
        if ($delete) {
            return $this->success($delete, __('messages.delete_success'));
        }
        return $this->error(__('messages.delete_failed'));
    }
}
