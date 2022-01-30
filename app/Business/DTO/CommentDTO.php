<?php

namespace App\Business\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class CommentDTO extends DataTransferObject
{
    public string $name;
    public string $comment;
    public int $postId;
}
