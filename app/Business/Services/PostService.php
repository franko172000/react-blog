<?php

namespace App\Business\Services;

use App\Business\DTO\CommentDTO;
use App\Business\DTO\GetPostsDTO;
use App\Business\DTO\PostDTO;
use App\Persistence\Models\Comment;
use App\Persistence\Repositories\PostRepository;
use Illuminate\Database\Eloquent\Model;

class PostService
{
    /**
     * App\Repositories\PostRepository $repository
     *
     * @var PostRepository
     */
    private PostRepository $repository;

    /**
     * Contructor method
     *
     * @param PostRepository $repository
     */
    public function __construct(PostRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param PostDTO $data
     * @return Model
     */
    public function addPost(PostDTO $data): Model
    {
        return $this->repository->createPost($data);
    }

    /**
     * Add comment
     * @param CommentDTO $data
     * @return Comment
     */
    public function addComment(CommentDTO $data): Comment
    {
        return $this->repository->addComment($data);
    }

    /**
     * @param GetPostsDTO $data
     * @return mixed
     */
    public function getPosts(GetPostsDTO $data)
    {
        return $this->repository->getPosts($data);
    }
}
