<?php

namespace Database\Seeders;

use App\Persistence\Models\Category;
use App\Persistence\Models\Post;
use App\Persistence\Models\User;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory()
            ->count(10)
            ->create();
    }
}
