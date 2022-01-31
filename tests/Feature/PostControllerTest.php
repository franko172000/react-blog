<?php

namespace Tests\Feature;

use App\Persistence\Models\Category;
use App\Persistence\Models\Post;
use App\Persistence\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\BaseTestCase;

class PostControllerTest extends BaseTestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;

    public function testUserCanAddPost()
    {
        $user = $this->makeUser();
        $this->makeCategory();
        $postData = [
            'title' => 'This is a test post',
            'description' => 'This is a test description',
            'category' => 1
        ];

        $response = $this->actingAs($user)
            ->withSession(['USER_SESSION' => time()])
            ->post('/user/add-post', $postData, [
            'Accept' => 'application/json'
        ]);

        $data = json_decode($response->content(), true);
        $response->assertJsonStructure([
            'data' => [
                'id',
                'title',
                'description',
                'publicationDate'
            ]
        ]);

        $responseData = $data['data'];
        $post = Post::find($responseData['id']);
        $this->assertEquals($post->id, $responseData['id']);
        $this->assertEquals($post->user_id, $user->id);
        $this->assertEquals($postData['title'], $responseData['title']);
        $this->assertEquals($postData['description'], $responseData['description']);
        $response->assertStatus(201);
    }

    public function testGuestUserCanNotAddPost()
    {
        $postData = [
            'title' => 'This is a test post',
            'description' => 'This is a test description',
        ];

        $response = $this->post('/user/add-post', $postData, [
            'Accept' => 'application/json'
        ]);

        $this->handleUnAuthenticatedAssertions($response);
    }

    public function testUserCanGetPosts()
    {
        $totalPost = 50;
        $defaultLimit = 20;
        $user = $this->makeUser();
        $this->makeCategory();
        $user->posts()
            ->saveMany(Post::factory()
            ->count($totalPost)
            ->make([
                'category_id' => Category::randomCategory()->id
            ]));

        $response = $this->actingAs($user)
            ->withSession(['USER_SESSION' => time()])
            ->get('/user/posts', [
                'Accept' => 'application/json'
            ]);

        $response->assertJsonStructure([
            'data' => [
                [
                    'id',
                    'title',
                    'description',
                    'publicationDate',
                    'category'
                ]
            ],
            'links',
            'meta'
        ]);

        $data = json_decode($response->content(), true);
        $this->assertCount($defaultLimit, $data['data']);
        $this->assertArrayHasKey('meta', $data);
        $this->assertArrayHasKey('total', $data['meta']);
        $this->assertEquals($totalPost, $data['meta']['total']);

        $response->assertStatus(200);
    }

    public function testUserCanGetPostsWithCustomLimit()
    {
        $totalPost = 50;
        $limit = 30;
        $user = $this->makeUser();
        $this->makeCategory();
        $user->posts()
            ->saveMany(Post::factory()
            ->count($totalPost)
            ->make([
                'category_id' => Category::randomCategory()->id
            ]));

        $response = $this->actingAs($user)
            ->withSession(['USER_SESSION' => time()])
            ->get('/user/posts?limit=' . $limit, [
                'Accept' => 'application/json'
            ]);

        $data = json_decode($response->content(), true);
        $this->assertCount($limit, $data['data']);
        $this->assertArrayHasKey('meta', $data);
        $this->assertArrayHasKey('total', $data['meta']);
        $this->assertEquals($totalPost, $data['meta']['total']);

        $response->assertStatus(200);
    }

    public function testPostsPagination()
    {
        $totalPost = 50;
        $limit = 30;
        $user = $this->makeUser();
        $this->makeCategory();
        $user->posts()
            ->saveMany(Post::factory()
                ->count($totalPost)
                ->make([
                    'category_id' => Category::randomCategory()->id
                ]));

        $response = $this->actingAs($user)
            ->withSession(['USER_SESSION' => time()])
            ->get('/user/posts?limit=' . $limit . '&page=2', [
                'Accept' => 'application/json'
            ]);

        $data = json_decode($response->content(), true);
        $this->assertCount(20, $data['data']);
        $this->assertArrayHasKey('meta', $data);
        $this->assertArrayHasKey('total', $data['meta']);
        $this->assertEquals(2, $data['meta']['current_page']);

        $response->assertStatus(200);
    }

    public function testGuestsCanGetPosts()
    {
        $totalPost = 10;
        $defaultLimit = 20;
        $this->makeCategory();
        User::factory()
            ->count(10)
            ->create()
            ->each(function ($usr) use ($totalPost) {
                $usr->posts()
                    ->saveMany(Post::factory()
                        ->count($totalPost)
                        ->make([
                            'category_id' => Category::randomCategory()->id
                        ]));
            });


        $response = $this->get('/posts', [
                'Accept' => 'application/json'
            ]);

        $data = json_decode($response->content(), true);
        $this->assertCount($defaultLimit, $data['data']);
        $this->assertArrayHasKey('meta', $data);
        $this->assertArrayHasKey('total', $data['meta']);
        $this->assertEquals(100, $data['meta']['total']);

        $response->assertStatus(200);
    }

    public function testAddPostValidationNoTitle()
    {
        $user = $this->makeUser();

        $postData = [
            'description' => 'This is a test description',
        ];

        $response = $this->actingAs($this->makeUser())
            ->withSession(['USER_SESSION' => time()])
            ->post('/user/add-post', $postData, [
                'Accept' => 'application/json'
            ]);

        $this->handleSingleFieldValidation($response, 'Title is required');
    }

    public function testAddPostValidationMinTitleCharacters()
    {
        $user = $this->makeUser();

        $postData = [
            'title' => 'r',
            'description' => 'This is a test description',
        ];

        $response = $this->actingAs($this->makeUser())
            ->withSession(['USER_SESSION' => time()])
            ->post('/user/add-post', $postData, [
                'Accept' => 'application/json'
            ]);

        $this->handleSingleFieldValidation($response, 'Title must have at least 2 characters');
    }

    public function testAddPostValidationCheckTitleType()
    {
        $user = $this->makeUser();

        $postData = [
            'title' => 4433,
            'description' => 'This is a test description',
        ];

        $response = $this->actingAs($this->makeUser())
            ->withSession(['USER_SESSION' => time()])
            ->post('/user/add-post', $postData, [
                'Accept' => 'application/json'
            ]);

        $this->handleSingleFieldValidation($response, 'Title must be a string');
    }

    public function testAddPostValidationNoDescription()
    {
        $user = $this->makeUser();

        $postData = [
            'title' => 'Test title'
        ];

        $response = $this->actingAs($this->makeUser())
            ->withSession(['USER_SESSION' => time()])
            ->post('/user/add-post', $postData, [
                'Accept' => 'application/json'
            ]);

        $this->handleSingleFieldValidation($response, 'Description is required');
    }

    public function testAddPostValidationMinDescriptionCharacters()
    {
        $user = $this->makeUser();

        $postData = [
            'title' => 'Test title',
            'description' => 'T',
        ];

        $response = $this->actingAs($this->makeUser())
            ->withSession(['USER_SESSION' => time()])
            ->post('/user/add-post', $postData, [
                'Accept' => 'application/json'
            ]);

        $this->handleSingleFieldValidation($response, 'Description must have at least 2 characters');
    }

    public function testAddPostValidationCheckDescriptionType()
    {
        $user = $this->makeUser();

        $postData = [
            'title' => 'Test title',
            'description' => 111,
        ];

        $response = $this->actingAs($this->makeUser())
            ->withSession(['USER_SESSION' => time()])
            ->post('/user/add-post', $postData, [
                'Accept' => 'application/json'
            ]);

        $this->handleSingleFieldValidation($response, 'Description must be a string');
    }

    public function testAddPostValidationNoCategory()
    {
        $user = $this->makeUser();

        $postData = [
            'title' => 'This is a test title',
            'description' => 'This is a test description',
        ];

        $response = $this->actingAs($this->makeUser())
            ->withSession(['USER_SESSION' => time()])
            ->post('/user/add-post', $postData, [
                'Accept' => 'application/json'
            ]);

        $this->handleSingleFieldValidation($response, 'Category is required');
    }

    public function testAddPostValidationCategoryMustBeInteger()
    {
        $user = $this->makeUser();

        $postData = [
            'title' => 'This is a test title',
            'description' => 'This is a test description',
            'category' => 'test',
        ];

        $response = $this->actingAs($this->makeUser())
            ->withSession(['USER_SESSION' => time()])
            ->post('/user/add-post', $postData, [
                'Accept' => 'application/json'
            ]);

        $this->handleSingleFieldValidation($response, 'Category must be a number');
    }

    private function makeUser()
    {
        return User::factory()->create();
    }

    private function makeCategory(){
        return Category::factory()->count(10)->create();
    }
}
