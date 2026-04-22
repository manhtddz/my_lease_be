<?php

namespace App\Repositories\Api;

use App\Models\User;
use App\Repositories\CustomRepository;
use Illuminate\Support\Facades\Hash;

class AuthRepository extends CustomRepository
{
    protected $model = User::class;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Find user by email
     *
     * @param string $email
     * @return User|null
     */
    public function findByEmail(string $email): ?User
    {
        return $this->getModel()->where('email', $email)->first();
    }

    /**
     * Verify user password
     *
     * @param User $user
     * @param string $password
     * @return bool
     */
    public function verifyPassword(User $user, string $password): bool
    {
        return Hash::check($password, $user->password);
    }

    /**
     * Create new user
     *
     * @param array $data
     * @return User
     */
    public function createUser(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        return $this->getModel()->create($data);
    }

    /**
     * Get user by ID
     *
     * @param int $id
     * @return User|null
     */
    public function findById(int $id): ?User
    {
        return $this->getModel()->find($id);
    }
}
