<?php

namespace App\Business\Services;

use App\Business\DTO\UserDTO;
use App\Persistence\Models\User;
use App\Persistence\Repositories\UserRepository;

class AuthService
{
    /**
     * App\Repositories\UserRepository $repository
     *
     * @var UserRepository
     */
    private UserRepository $repository;

    /**
     * Contructor method
     *
     * @param UserRepository $repository
     */
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Create new user
     * @param UserDTO $data
     * @return User
     */
    public function createUser(UserDTO $data): User
    {
        return $this->repository->createUser($data);
    }
}
