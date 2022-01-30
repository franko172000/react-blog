<?php

namespace App\Http\Controllers;

use App\Business\DTO\CommentDTO;
use App\Business\DTO\GetPostsDTO;
use App\Business\DTO\PostDTO;
use App\Business\Services\PostService;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\PostRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class PostController extends Controller
{
    protected PostService $postService;
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    /**
     * @param PostRequest $request
     * @return PostResource
     * @throws UnknownProperties
     */
    public function addPost(PostRequest $request): PostResource
    {
        $user = auth()->user();
        $data = $request->validated();
        $post =  $this->postService->addPost(new PostDTO([
            'title' => $data['title'],
            'description' => $data['description'],
            'user' => $user,
            'publishedDate' => now()
        ]));

        return new PostResource($post);
    }

    /**
     * Add comment to post
     * @param CommentRequest $request
     * @return CommentResource
     * @throws UnknownProperties
     */
    public function addComment(CommentRequest $request): CommentResource
    {
        $data = $request->validated();
        $post =  $this->postService->addComment(new CommentDTO([
            'name' => $data['name'],
            'postId' => $data['postId'],
            'comment' => $data['comment'],
        ]));

        return new CommentResource($post);
    }

    /**
     * @param Request $request
     * @return AnonymousResourceCollection
     * @throws UnknownProperties
     */
    public function getUserPosts(Request $request): AnonymousResourceCollection
    {
        $data = $request->all();
        $params = [
            'user' => auth()->user()
        ];

        if (isset($data['limit'])) {
            $params['limit'] = $data['limit'];
        }

        if (isset($data['sortOrder'])) {
            $params['sortOrder'] = $data['sortOrder'];
        }

        $posts =  $this->postService->getPosts(new GetPostsDTO($params));

        return PostResource::collection($posts);
    }

    /**
     * Get posts for everyone
     * @param Request $request
     * @return AnonymousResourceCollection
     * @throws UnknownProperties
     */
    public function getPosts(Request $request): AnonymousResourceCollection
    {
        $data = $request->all();
        $params = [];
        if (isset($data['limit'])) {
            $params['limit'] = $data['limit'];
        }

        if (isset($data['sortOrder'])) {
            $params['sortOrder'] = $data['sortOrder'];
        }

        $posts =  $this->postService->getPosts(new GetPostsDTO($params));

        return PostResource::collection($posts);
    }
}
