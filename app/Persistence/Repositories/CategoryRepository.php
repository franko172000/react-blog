<?php

namespace App\Persistence\Repositories;

use App\Business\DTO\CommentDTO;
use App\Business\DTO\GetPostsDTO;
use App\Business\DTO\PostDTO;
use App\Persistence\Models\Category;
use App\Persistence\Models\Comment;
use App\Persistence\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CategoryRepository
{
    /** @var Category  */
    protected Category $model;

    /**
     * @param Category $model
     */
    public function __construct(Category $model)
    {
        $this->model = $model;
    }

    /**
     * @return Category[]|Collection
     */
    public function getCategories(): Collection
    {
        return $this->model->all();
    }
}
