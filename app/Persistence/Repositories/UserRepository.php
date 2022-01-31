<?php

namespace App\Persistence\Repositories;

use App\Business\DTO\UserDTO;
use App\Persistence\Models\User;

class UserRepository
{
    /** @var User  */
    protected User $model;

    /**
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * Create new user
     * @param UserDTO $data
     * @return User
     */
    public function createUser(UserDTO $data): User
    {
        $userData = [
            'email' => $data->email,
            'password' => bcrypt($data->password),
            'first_name' => $data->firstName,
            'last_name' => $data->lastName,
            'user_type' => 'user',
            'email_verified_at' => now()
        ];
        return $this->model->create($userData);
    }
}
