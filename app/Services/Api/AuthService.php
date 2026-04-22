<?php

namespace App\Services\Api;

use App\Models\User;
use App\Repositories\Api\AuthRepository;
use App\Services\CustomService;

class AuthService extends CustomService
{
    protected AuthRepository $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        parent::__construct();
        $this->authRepository = $authRepository;
        $this->setRepository($authRepository);
    }

    /**
     * Authenticate user with email and password
     *
     * @param string $email
     * @param string $password
     * @return User|null
     */
    public function authenticate(string $email, string $password): ?User
    {
        $user = $this->authRepository->findByEmail($email);

        if (!$user) {
            return null;
        }

        if (!$this->authRepository->verifyPassword($user, $password)) {
            return null;
        }

        return $user;
    }

    /**
     * Create authentication token for user
     *
     * @param User $user
     * @param string $tokenName
     * @return string
     */
    public function createToken(User $user, string $tokenName = 'auth_token'): string
    {
        return $user->createToken($tokenName)->plainTextToken;
    }

    /**
     * Revoke all tokens for user
     *
     * @param User $user
     * @return void
     */
    public function revokeAllTokens(User $user): void
    {
        $user->tokens()->delete();
    }

    /**
     * Register new user
     *
     * @param array $data
     * @return User
     */
    public function register(array $data): User
    {
        return $this->authRepository->createUser($data);
    }

    /**
     * Get authenticated user
     *
     * @return User|null
     */
    public function getAuthUser(): ?User
    {
        return auth('api')->user();
    }
}
