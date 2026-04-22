<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseApiController;
use App\Services\Api\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends BaseApiController
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        parent::__construct();
        $this->authService = $authService;
    }

    /**
     * Login user and return token
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return $this->error(
                __('messages.validation_error'),
                Response::HTTP_UNPROCESSABLE_ENTITY,
                $validator->errors()->toArray()
            );
        }

        $user = $this->authService->authenticate(
            $request->input('email'),
            $request->input('password')
        );

        if (!$user) {
            return $this->error(
                __('messages.invalid_credentials'),
                Response::HTTP_UNAUTHORIZED
            );
        }

        $token = $this->authService->createToken($user, 'api_token');

        return $this->success([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], __('messages.login_success'));
    }

    /**
     * Register new user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->error(
                __('messages.validation_error'),
                Response::HTTP_UNPROCESSABLE_ENTITY,
                $validator->errors()->toArray()
            );
        }

        $user = $this->authService->register($request->only(['name', 'email', 'password']));
        $token = $this->authService->createToken($user, 'api_token');

        return $this->success([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ],
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], __('messages.register_success'), Response::HTTP_CREATED);
    }

    /**
     * Logout user (revoke token)
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        // Lấy user từ authenticated token (Sanctum)
        $user = $request->user();

        if ($user) {
            // Revoke current token (token đang được dùng)
            $token = $request->user()->currentAccessToken();
            if ($token) {
                $token->delete();
            }

            // Hoặc revoke tất cả tokens (uncomment nếu muốn)
            // $this->authService->revokeAllTokens($user);
        }

        return $this->success([], __('messages.logout_success'));
    }

    /**
     * Get authenticated user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function me(Request $request): JsonResponse
    {
        $user = $this->authService->getAuthUser();

        if (!$user) {
            return $this->error(
                __('messages.not_authenticated'),
                Response::HTTP_UNAUTHORIZED
            );
        }

        return $this->success($user);
    }
}
