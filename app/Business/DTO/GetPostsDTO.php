<?php

namespace App\Business\DTO;

use App\Persistence\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

class GetPostsDTO extends DataTransferObject
{
    public string $sortOrder = "new";
    public int $limit = 20;
    public int $page = 1;
    public ?User $user;
}
