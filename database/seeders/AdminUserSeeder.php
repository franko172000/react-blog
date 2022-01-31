<?php

namespace Database\Seeders;

use App\Persistence\Models\Category;
use App\Persistence\Models\Post;
use App\Persistence\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
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
            ->create([
              'user_type' => 'admin'
            ]);
    }
}
