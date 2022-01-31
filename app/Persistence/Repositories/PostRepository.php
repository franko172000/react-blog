<?php

namespace App\Persistence\Repositories;

use App\Business\DTO\CommentDTO;
use App\Business\DTO\GetPostsDTO;
use App\Business\DTO\PostDTO;
use App\Persistence\Models\Comment;
use App\Persistence\Models\Post;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PostRepository
{
    /** @var Post  */
    protected Post $model;

    /**
     * @param Post $model
     */
    public function __construct(Post $model)
    {
        $this->model = $model;
    }

    /**
     * Add new post
     * @param PostDTO $data
     * @return Model
     */
    public function createPost(PostDTO $data): Model
    {
        $postData = [
            'title' => $data->title,
            'description' => $data->description,
            'category_id' => $data->category,
            'publication_date' => $data->publishedDate
        ];

        return $data->user
            ->posts()
            ->create($postData);
    }

    /**
     * Add comments to post
     * @param CommentDTO $data
     * @return Comment
     */
    public function addComment(CommentDTO $data): Comment
    {
        $post = $this->model->findOrFail($data->postId);

        return $post->comment()->create([
            'name' => $data->name,
            'comment' => $data->comment
        ]);
    }

    /**
     * Get user posts
     * @return mixed
     */
    public function getPosts(GetPostsDTO $data)
    {
        $postObj =  $data->user
            ? $data->user->posts()
            : $this->model;

        if ($data->sortOrder === 'new') {
            $postObj = $postObj->newestPosts();
        } else {
            $postObj = $postObj->oldestPosts();
        }

        return $postObj
            ->with('category')
            ->paginate($data->limit, ['*'], 'page', $data->page);
    }


    /**
     * Get post by ID
     * @param int $id
     * @return Builder|Model
     */
    public function getPostById(int $id)
    {
        return $this->model
            ->with('category')
            ->whereId($id)
            ->firstOrFail();
    }
}
