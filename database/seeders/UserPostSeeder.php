<?php

namespace Database\Seeders;

use App\Persistence\Models\Category;
use App\Persistence\Models\Post;
use App\Persistence\Models\User;
use Illuminate\Database\Seeder;

class UserPostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory()
            ->count(20)
            ->create()
            ->each(function ($user) {
                $user->posts()
                    ->saveMany(
                        Post::factory()
                        ->count(50)
                        ->make([
                            'category_id' => Category::inRandomOrder()->first(['id'])->id
                        ])
                    );
            });
    }
}
