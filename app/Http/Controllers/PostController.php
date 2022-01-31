<?php

namespace App\Http\Controllers;

use App\Business\DTO\CommentDTO;
use App\Business\DTO\GetPostsDTO;
use App\Business\DTO\PostDTO;
use App\Business\Services\PostService;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\PostRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
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
            'category' => $data['category'],
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

        $posts = $this->postSetup($data, true);

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

        $posts = $this->postSetup($data);
        return PostResource::collection($posts);
    }

    /**
     * Get single post
     * @param int $id
     * @return PostResource
     */
    public function getPost(int $id): PostResource
    {
        $posts = $this->postService->getSinglePost($id);
        return new PostResource($posts);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function categories(): AnonymousResourceCollection
    {
        $categories = $this->postService->getCategories();
        return CategoryResource::collection($categories);
    }

    /**
     * @param array $data
     * @param bool $userPosts
     * @return mixed
     * @throws UnknownProperties
     */
    private function postSetup(array $data, bool $userPosts = false)
    {
        $params = [];
        if ($userPosts) {
            $params = [
                'user' => auth()->user()
            ];
        }
        if (isset($data['limit'])) {
            $params['limit'] = $data['limit'];
        }

        if (isset($data['sortOrder'])) {
            $params['sortOrder'] = $data['sortOrder'];
        }

        if (isset($data['page'])) {
            $params['page'] = $data['page'];
        }

        return $this->postService->getPosts(new GetPostsDTO($params));
    }
}
