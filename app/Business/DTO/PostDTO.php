<?php

namespace App\Business\DTO;

use App\Persistence\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

class PostDTO extends DataTransferObject
{
    public string $title;
    public string $description;
    public ?string $publishedDate;
    public User $user;
}
