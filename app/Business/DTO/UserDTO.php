<?php

namespace App\Business\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class UserDTO extends DataTransferObject
{
    public string $firstName;
    public string $lastName;
    public string $email;
    public string $password;
}
