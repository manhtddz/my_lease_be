<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Api\BaseApiController;
use App\Repositories\ApiClientRepository;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthAPI extends BaseApiController
{
    public function __construct( public ApiClientRepository $apiClientRepository)
    {
        parent::__construct();
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ip = getUserIpAddr();
        $accessKey = $request->header('x-api-key');
        $result = $this->apiClientRepository->isExistClient($accessKey, $ip);
        if (!$result) {
            $this->setCode(Response::HTTP_BAD_REQUEST);
            $this->setMessage(__('messages.http_code.400'));
            return $this->responseMessage();
        }
        return $next($request);
    }

}
