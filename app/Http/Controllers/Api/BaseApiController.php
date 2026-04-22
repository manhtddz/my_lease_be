<?php

namespace App\Http\Controllers\Api;

use App\Enums\ApiStatusEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BaseApiController extends Controller
{
    protected int $code = Response::HTTP_OK;
    protected string $message = '';
    protected mixed $data = [];

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Set response code
     *
     * @param int $code
     * @return $this
     */
    protected function setCode(int $code): self
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Set response message
     *
     * @param string $message
     * @return $this
     */
    protected function setMessage(string $message): self
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Set response data
     *
     * @param mixed $data
     * @return $this
     */
    protected function setData(mixed $data): self
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Return response message
     *
     * @return JsonResponse
     */
    protected function responseMessage(): JsonResponse
    {
        $status = $this->code >= 200 && $this->code < 300
            ? ApiStatusEnum::SUCCESS
            : ApiStatusEnum::ERROR;

        return response()->json([
            'status' => $status,
            'message' => $this->message ?: __('messages.success'),
            'data' => $this->data,
        ], $this->code);
    }

    /**
     * Return success response
     *
     * @param mixed $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    protected function success(mixed $data = [], string $message = '', int $code = Response::HTTP_OK): JsonResponse
    {
        return $this->setCode($code)
            ->setMessage($message)
            ->setData($data)
            ->responseMessage();
    }

    /**
     * Return error response
     *
     * @param string $message
     * @param int $code
     * @param mixed $data
     * @return JsonResponse
     */
    protected function error(string $message = '', int $code = Response::HTTP_BAD_REQUEST, mixed $data = []): JsonResponse
    {
        return $this->setCode($code)
            ->setMessage($message)
            ->setData($data)
            ->responseMessage();
    }
}
