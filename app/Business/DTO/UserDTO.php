<?php

namespace App\Business\DTO;

use Spatie\DataTransferObject\Attributes\Strict;
use Spatie\DataTransferObject\DataTransferObject;

#[Strict]
class UserDTO extends DataTransferObject
{
    public string $firstName;
    public string $lastName;
    public string $email;
    public string $password;
}
