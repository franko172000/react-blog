<?php

namespace Tests\Feature;

use App\Persistence\Models\Category;
use App\Persistence\Models\Post;
use App\Persistence\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ExternalPostsPullTest extends TestCase
{
    use DatabaseTransactions;
    use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        //add categories
        Category::factory()
            ->count(10)
            ->create();
        //add user
        User::factory()->count(1)
            ->create([
                'user_type' => 'admin'
            ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPostsCanBePulledFrom3rdParty()
    {
        $mockData = $this->mockResponse();
        Http::fake([
            config('system.external_post_endpoint') => Http::sequence()
                ->push($mockData),
        ]);

        Artisan::call('external-post:pull');

        $posts = Post::all();
        $this->assertCount($posts->count(), $mockData['data']);
        $postData = $posts[0];
        $mock = $mockData['data'][0];
        $this->assertEquals($postData->title, $mock['title']);
        $this->assertEquals($postData->description, $mock['description']);
        $this->assertEquals($postData->publication_date, $mock['publication_date']);
    }

    /**
     * Mock 3rd party response
     * @return array
     */
    private function mockResponse(): array
    {
        return [
            'data' => Post::factory()->count(5)->make()
        ];
    }
}
