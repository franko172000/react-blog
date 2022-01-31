<?php

namespace App\Business\Services;

use App\Persistence\Models\Category;
use App\Persistence\Models\Post;
use App\Persistence\Models\User;
use Illuminate\Support\Facades\Http;

class ExternalPostService
{
    protected string $endpoint;

    public function __construct()
    {
        $this->endpoint = config('system.external_post_endpoint');
    }

    /**
     * Pull external posts
     */
    public function pullPosts()
    {
        $response = Http::get($this->endpoint);
        $posts = json_decode($response->body(), true);
        $postData = [];
        $user = User::adminUser()->first();
        foreach ($posts['data'] as $post) {
            $postData[] = [
                'title' => $post['title'],
                'description' => $post['description'],
                'category_id' => Category::randomCategory()->id,
                'user_id' => $user->id,
                'publication_date' => $post['publication_date']
            ];
        }
        Post::insert($postData);
    }
}
